<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Admin;

/**
 * 
 */
class UserRepository 
{
	
	function __construct()
	{
		return Admin::class;
	}
}