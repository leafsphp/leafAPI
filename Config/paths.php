<?php

/**
 * Views directory path
 */
function views_path($path = null, bool $slash = false)
{
	return $slash ? "/App/Views/$path" : "App/Views/$path";
}

/**
 * Config directory path
 */
function config_path($path = null)
{
	return "/Config/$path";
}

/**
 * Storage directory path 
 */
function storage_path($path = null, bool $slash = false)
{
	return $slash ? "/storage/$path" : "storage/$path";
}

/**
 * Commands directory path
 */
function commands_path($path = null)
{
	return "/App/Console/$path";
}

/**
 * Controllers directory path
 */
function controllers_path($path = null)
{
	return "/App/Controllers/$path";
}

/**
 * Models directory path
 */
function models_path($path = null)
{
	return "/App/Models/$path";
}

/**
 * Migrations directory path
 */
function migrations_path($path = null, bool $slash = true)
{
	return  $slash ? "/App/Database/Migrations/$path" : "App/Database/Migrations/$path";
}

/**
 * Seeds directory path
 */
function seeds_path($path = null)
{
	return "/App/Database/Seeds/$path";
}

/**
 * Factories directory path
 */
function factories_path($path = null)
{
	return "/App/Database/Factories/$path";
}

/**
 * Routes directory path
 */
function routes_path($path = null)
{
	return "/App/Routes/$path";
}

/**
 * Helpers directory path
 */
function helpers_path($path = null)
{
	return "/App/Helpers/$path";
}

/**
 * Helpers directory path
 */
function lib_path($path = null)
{
	return "/Lib/$path";
}

/**
 * Public directory path
 */
function public_path($path = null)
{
	return "/public/$path";
}
