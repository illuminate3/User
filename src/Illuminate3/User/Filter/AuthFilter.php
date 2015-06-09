<?php

namespace Illuminate3\User\Filter;

use Sentry, Redirect;

class AuthFilter
{
	/**
	 * @param \Illuminate\Routing\Route $route
	 * @return mixed
	 */
	public function filter(\Illuminate\Routing\Route $route)
	{
		$page = $route->getOption('page');
		$user = Sentry::getUser();

		// Fake a guest user when user is not logged in
		if(!$user) {
			$user = Sentry::findUserByCredentials(array('email' => 'guest'));
		}

		// Check if the user has permission
		$hasAccess = $user->hasAccess('view.page.' . $page->alias);

		// User is not logged in yet
		if (!$hasAccess && $user->email == 'guest') return Redirect::route('user.login');

		// User has no rights
		if (!$hasAccess) return Redirect::route('user.login');

	}
}
