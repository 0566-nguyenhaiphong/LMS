<?php
/**
 * Quiz review model service provider.
 *
 * @since 1.7.0
 */

namespace Masteriyo\Providers;

defined( 'ABSPATH' ) || exit;

use Masteriyo\Enums\CommentType;
use Masteriyo\PostType\PostType;
use Masteriyo\Models\QuizReview;
use Masteriyo\Repository\QuizReviewRepository;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Masteriyo\RestApi\Controllers\Version1\QuizReviewsController;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use PHP_CodeSniffer\Tokenizers\Comment;

class QuizReviewServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface {
	/**
	 * The provided array is a way to let the container
	 * know that a service is provided by this service
	 * provider. Every service that is registered via
	 * this service provider must have an alias added
	 * to this array or it will be ignored
	 *
	 * @since 1.7.0
	 *
	 * @var array
	 */
	protected $provides = array(
		'quiz_review',
		'quiz_review.store',
		'quiz_review.rest',
		'\Masteriyo\RestApi\Controllers\Version1\QuizReviewsController',
	);

	/**
	 * This is where the magic happens, within the method you can
	 * access the container and register or retrieve anything
	 * that you need to, but remember, every alias registered
	 * within this method must be declared in the `$provides` array.
	 *
	 * @since 1.7.0
	 */
	public function register() {
		$this->getContainer()->add( 'quiz_review.store', QuizReviewRepository::class );

		$this->getContainer()->add( 'quiz_review.rest', QuizReviewsController::class )
		->addArgument( 'permission' );

		$this->getContainer()->add( '\Masteriyo\RestApi\Controllers\Version1\QuizReviewsController' )
		->addArgument( 'permission' );

		$this->getContainer()->add( 'quiz_review', QuizReview::class )
		->addArgument( 'quiz_review.store' );
	}

	/**
	 * In much the same way, this method has access to the container
	 * itself and can interact with it however you wish, the difference
	 * is that the boot method is invoked as soon as you register
	 * the service provider with the container meaning that everything
	 * in this method is eagerly loaded.
	 *
	 * If you wish to apply inflectors or register further service providers
	 * from this one, it must be from a bootable service provider like
	 * this one, otherwise they will be ignored.
	 *
	 * @since 1.7.0
	 */
	public function boot() {
		add_filter( 'comments_open', array( $this, 'comments_open' ), 10, 2 );
		add_action( 'comment_moderation_recipients', array( $this, 'comment_moderation_recipients' ), 10, 2 );
		add_action( 'wp_update_comment_count', array( $this, 'wp_update_comment_count' ) );
		add_filter( 'get_avatar_comment_types', array( $this, 'add_avatar_for_review_comment_type' ) );
		add_action( 'parse_comment_query', array( $this, 'remove_quiz_review_from_query' ) );
	}

	/**
	 * See if comments are open.
	 *
	 * @since 1.7.0
	 *
	 * @param  bool $open    Whether the current post is open for comments.
	 * @param  int  $post_id Post ID.
	 *
	 * @return bool
	 */
	public function comments_open( $open, $post_id ) {
		if ( PostType::QUIZ === get_post_type( $post_id ) ) {
			$open = false;
		}
		return $open;
	}

	/**
	 * Ensure quiz average rating and review count is kept up to date.
	 *
	 * @since 1.7.0
	 *
	 * @param int $post
	 */
	public function wp_update_comment_count( $post ) {
		if ( PostType::QUIZ === get_post_type( $post ) ) {
			$this->update_quiz_review_stats( $post );
		}
	}

	/**
	 * Update average rating and review counts of quiz.
	 *
	 * @since 1.7.0
	 *
	 * @param int|string|\WP_Post|\Masteriyo\Models\Quiz $quiz
	 */
	public function update_quiz_review_stats( $quiz ) {
		$quiz = masteriyo_get_quiz( $quiz );

		if ( is_null( $quiz ) ) {
			return;
		}

		$quiz->set_rating_counts( $this->get_rating_counts( $quiz ) );
		$quiz->set_average_rating( $this->get_average_rating( $quiz ) );
		$quiz->set_review_count( $this->get_review_count( $quiz ) );
		$quiz->save();
	}

	/**
	 * Make sure WP displays avatars for comments with the `quiz_review` type.
	 *
	 * @since 1.7.0
	 *
	 * @param  array $comment_types Comment types.
	 *
	 * @return array
	 */
	public function add_avatar_for_review_comment_type( $comment_types ) {
		return array_merge( $comment_types, array( CommentType::QUIZ_REVIEW ) );
	}

	/**
	 * Modify recipient of review email.
	 *
	 * @since 1.7.0
	 *
	 * @param array $emails     Emails.
	 * @param int   $comment_id Comment ID.
	 *
	 * @return array
	 */
	public function comment_moderation_recipients( $emails, $comment_id ) {
		$comment = get_comment( $comment_id );

		if ( $comment && PostType::QUIZ === get_post_type( $comment->comment_post_ID ) ) {
			$emails = array( get_option( 'admin_email' ) );
		}

		return $emails;
	}

	/**
	 * Get quiz rating for a quiz. Please note this is not cached.
	 *
	 * @since 1.7.0
	 *
	 * @param \Masteriyo\Models\Quiz $quiz Quiz instance.
	 *
	 * @return float
	 */
	public function get_average_rating( $quiz ) {
		global $wpdb;

		$count = $quiz->get_rating_count();

		if ( $count ) {
			$ratings = $wpdb->get_var(
				$wpdb->prepare(
					"
					SELECT SUM(comment_karma) FROM $wpdb->comments
					WHERE comment_post_ID = %d
					AND comment_approved = '1'
					AND comment_type = 'mto_quiz_review'
					AND comment_parent = 0
					",
					$quiz->get_id()
				)
			);
			$average = number_format( $ratings / $count, 2, '.', '' );
		} else {
			$average = 0;
		}

		return $average;
	}

	/**
	 * Get quiz review count for a quiz (not replies). Please note this is not cached.
	 *
	 * @since 1.7.0
	 *
	 * @param \Masteriyo\Models\Quiz $quiz quiz instance.
	 *
	 * @return int
	 */
	public function get_review_count( $quiz ) {
		global $wpdb;

		$count = $wpdb->get_var(
			$wpdb->prepare(
				"
				SELECT COUNT(*) FROM $wpdb->comments
				WHERE comment_parent = 0
				AND comment_post_ID = %d
				AND comment_approved = '1'
				AND comment_type = 'mto_quiz_review'
				",
				$quiz->get_id()
			)
		);

		return $count;
	}

	/**
	 * Get quiz rating count for a quiz. Please note this is not cached.
	 *
	 * @since 1.7.0
	 *
	 * @param \Masteriyo\Models\Quiz $quiz quiz instance.
	 *
	 * @return int[]
	 */
	public function get_rating_counts( $quiz ) {
		global $wpdb;

		$counts     = array();
		$raw_counts = $wpdb->get_results(
			$wpdb->prepare(
				"
				SELECT comment_karma, COUNT( * ) as rating_count FROM $wpdb->comments
				WHERE comment_post_ID = %d
				AND comment_approved = '1'
				AND comment_karma > 0
				AND comment_type = 'mto_quiz_review'
				GROUP BY comment_karma
				",
				$quiz->get_id()
			)
		);

		foreach ( $raw_counts as $count ) {
			$counts[ $count->comment_karma ] = absint( $count->rating_count ); // WPCS: slow query ok.
		}

		return $counts;
	}

	/**
	 * Remove the quiz review from the comments query.
	 *
	 * @since 1.7.0
	 *
	 * @param \WP_Comment_Query $query
	 */
	public function remove_quiz_review_from_query( $query ) {
		// Bail early if  global pagenow is not set or isn't admin dashboard.
		if ( ! isset( $GLOBALS['pagenow'] ) || ! is_admin() ) {
			return;
		}

		// Bail if the page is not wp comments list page or dashboard.
		if ( ! in_array( $GLOBALS['pagenow'], array( 'edit-comments.php', 'index.php' ), true ) ) {
			return;
		}

		if ( ! isset( $query->query_vars['type__not_in'] ) ) {
			$query->query_vars['type__not_in'] = array();
		}

		$query->query_vars['type__not_in'] = (array) $query->query_vars['type__not_in'];
		$query->query_vars['type__not_in'] = array_unique( array_merge( $query->query_vars['type__not_in'], array( CommentType::QUIZ_REVIEW ) ) );
	}
}
