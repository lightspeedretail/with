<?php

/**
 * Function emulating Python's `with` statement.
 *
 * Example Usage:
 *
 * with (new FileOpeningContextManager($filename),
 *   function ($file) use ($data) {
 *     write($file, $data);
 *   }
 * );
 */
function with(ContextManager $mgr, callable $fn)
{
	$value = $mgr->enter__();
	$exc = true;
	try
	{
		try
		{
			$fn($value);
		}
		catch (Exception $exception)
		{
			$exc = false;
			if (!$mgr->exit__($exception))
			{
				throw $exception;
			}
		}
	}
	finally
	{
		if ($exc)
		{
			$mgr->exit__(null);
		}
	}
}
