<?php
/**
 * Custom Code
 *
 * Parsing/cleaning functions adapted from Flexi Custom Code by RBO Team > Project::: RumahBelanja.com & AppsNity.com.
 * https://extensions.joomla.org/extension/flexi-custom-code/
 *
 * @version 1.0.3
 * @author flutterderp
 * @package Joomla
 * @license GNU General Public License v3.0 or later; see LICENSE
 */

defined('_JEXEC') or die;

/**
 * Customcode
 *
 * @since 1.0.0
 */
class Customcode
{
	protected $codeblock = '';
	protected $clean_js  = 0;
	protected $clean_css = 0;
	protected $clean_all = 0;
	protected $use_php   = 0;

	function __construct(&$params)
	{
		$this->codeblock = $params->get('code_area', '');
		$this->clean_js  = (int) $params->get('clean_js', 0);
		$this->clean_css = (int) $params->get('clean_css', 0);
		$this->clean_all = (int) $params->get('clean_all', 0);
		$this->use_php   = (int) $params->get('use_php', 0);
	}

	function __deconstruct() { }

	/**
	 * Parses the code text area and prepares the output
	 *
	 * @return module_content
	 */
	function parseCode(stdClass $module)
	{
		$codeblock = $this->codeblock;

		if ((int) $this->clean_all === 1)
		{
			$codeblock = preg_replace('/<br(\s*\/*)>/', '', $codeblock);
		}
		else
		{
			if ((int) $this->clean_css === 1)
			{
				$codeblock = $this->cleanCSS($codeblock);
			}

			if ((int) $this->clean_js === 1)
			{
				$codeblock = $this->cleanJS($codeblock);
			}
		}

		if ((int) $this->use_php === 1)
		{
			// Create a temporary file to write our code to
			$tmp_file  = tempnam(JPATH_SITE . '/tmp', 'html');
			$handle    = fopen($tmp_file, 'w');
			$module_id = (int) $module->id;

			// Write to the temporary file
			fwrite($handle, $codeblock, strlen($codeblock));
			fclose($handle);

			// Include/execute the temporary file
			ob_start();
			include_once($tmp_file);
			$module_content = ob_get_clean();

			// And delete it after we're done
			unlink($tmp_file);
		}
		else
		{
			$module_content = $codeblock;
		}

		return trim($module_content);
	}

	/**
	 * Clean CSS
	 *
	 * @param codearea
	 * @return codearea
	 */
	protected function cleanCSS($codearea)
	{
		preg_match("/<style(.*)>(.*)<\/style>/i", $codearea, $matches);

		if ($matches)
		{
			foreach ($matches as $i => $match)
			{
				$cleaned  = preg_replace('/<br(\s*\/*)>/', '', $match);
				$codearea = str_replace($match, $cleaned, $codearea);
			}

			return $codearea;
		}
		else
		{
			return $codearea;
		}
	}

	/**
	 * Clean JS
	 *
	 * @param codearea
	 * @return codearea
	 */
	protected function cleanJS($codearea)
	{
		preg_match("/<script(.*)>(.*)<\/script>/i", $codearea, $matches);

		if ($matches)
		{
			foreach ($matches as $i => $match)
			{
				$cleaned  = preg_replace('/<br(\s*\/*)>/', '', $match);
				$codearea = str_replace($match, $cleaned, $codearea);
			}

			return $codearea;
		}
		else
		{
			return $codearea;
		}
	}

}
