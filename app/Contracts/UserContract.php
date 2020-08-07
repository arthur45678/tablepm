<?php

namespace App\Contracts;

interface UserContract
{
	/**
     * Get all users
     */
	public function getUsers();

	/**
     * Add user
     */
    public function addUser($data);
}
