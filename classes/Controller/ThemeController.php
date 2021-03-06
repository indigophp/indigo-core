<?php

/*
 * This file is part of the Indigo Core package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Core\Controller;

/**
 * Theme Controller
 *
 * Some description
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
trait ThemeController
{
	use TemplateController {
		init as template_init;
	}

	/**
	 * {@inheritdoc}
	 *
	 * Loads the theme and sets the template object
	 */
	public function before()
	{
		parent::before();

		$this->init();
	}

	/**
	 * Loads the theme and sets the template object
	 */
	protected function init()
	{
		if (isset($this->theme) === false)
		{
			throw new \RuntimeException('Theme property does not exist.');
		}

		if (empty($this->theme) === false and is_string($this->theme))
		{
			$this->theme = \Theme::instance($this->theme);
		}

		// Sets active theme
		if (empty($this->theme_active) === false and is_string($this->theme_active))
		{
			$this->theme->active($this->theme_active);
		}

		// Initialize template
		$this->template_init();

		$this->theme->set_template($this->template);

		// Makes the theme instance available in all views
		$this->template->set_global('theme', $this->theme, false);
	}

	/**
	 * {@inheritdoc}
	 *
	 * @see Fuel\Core\Theme::view
	 */
	protected function view($view, $data = [], $auto_filter = null)
	{
		return $this->theme->view($view, $data, $auto_filter);
	}
}
