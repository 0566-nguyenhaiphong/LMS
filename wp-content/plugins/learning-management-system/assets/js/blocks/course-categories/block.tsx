import { __ } from '@wordpress/i18n';
import React from 'react';
import { Icon } from '../components';
import Edit from './Edit';
import attributes from './attributes';
import './editor.scss';

export function registerCourseCategoriesBlock() {
	wp.blocks.registerBlockType('masteriyo/course-categories', {
		title: 'Course Categories',
		description: __(
			'Display a collection of course categories.',
			'learning-management-system',
		),
		icon: <Icon type="blockIcon" name="course-categories" size={24} />,
		category: 'masteriyo',
		keywords: ['Course Categories Block'],
		attributes,
		supports: {
			align: false,
			html: false,
			color: {
				background: false,
				gradient: false,
				text: false,
			},
		},
		edit: Edit,
		save: () => null,
	});
}
