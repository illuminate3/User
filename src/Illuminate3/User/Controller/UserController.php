<?php

namespace Illuminate3\User\Controller;

use Illuminate3\Crud\CrudController;
use Illuminate3\Form\FormBuilder;
use Illuminate3\Model\ModelBuilder;
use Illuminate3\Overview\OverviewBuilder;
use User;

class UserController extends CrudController
{
	/**
	 * @param FormBuilder $fb
	 */
	public function buildForm(FormBuilder $fb)
	{
		$fb->text('email')->label('E-mail')->rules('required|email');
		$fb->text('first_name')->label('First name');
		$fb->text('last_name')->label('Last name');
		$fb->password('password')->label('Password');
		$fb->modelCheckbox('users_groups')->model('Cartalyst\Sentry\Groups\Eloquent\Group')->field('name')->label('User groups');
	}

	/**
	 * @param ModelBuilder $mb
	 */
	public function buildModel(ModelBuilder $mb)
	{
		$mb->name('User')->table('users');
	}

	/**
	 * @param OverviewBuilder $ob
	 */
	public function buildOverview(OverviewBuilder $ob)
	{
		$ob->fields(array('email', 'first_name', 'last_name'));
	}
}

