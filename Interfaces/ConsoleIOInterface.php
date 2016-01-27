<?php
namespace Selenia\Interfaces;

use Symfony\Component\Console\Formatter\OutputFormatterStyleInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * An API that provides input and output from/to the terminal.
 * This interface declares methods from `CommandAPI` and from the inherited `Robo\Common\IO`.
 */
interface ConsoleIOInterface
{
  /**
   * @param string $question
   * @param bool   $hideAnswer
   * @return string
   */
  function ask ($question, $hideAnswer = false);

  /**
   * @param string $question
   * @param string $default
   * @return string
   */
  function askDefault ($question, $default);

  /**
   * @param string $question
   * @return string
   */
  function askHidden ($question);

  /**
   * @param string $text
   * @param int    $width 0 = autofit
   * @return $this
   */
  function banner ($text, $width = 0);

  /**
   * @return $this
   */
  function clear ();

  /**
   * @param string $text
   * @return $this
   */
  function comment ($text);

  /**
   * @param string $question
   */
  function confirm ($question);

  /**
   * @param string $text
   */
  function done ($text);

  /**
   * Prints an error message and stops execution. Use only on commands, not on tasks.
   *
   * @param string $text  The message.
   * @param int    $width Error box width.
   */
  function error ($text, $width = 0);

  /**
   * @return QuestionHelper
   */
  function getDialog ();

  /**
   * @return InputInterface
   */
  function getInput ();

  /**
   * @return OutputInterface
   */
  function getOutput ();

  /**
   * Presents a list to the user, from which he/she must select an item.
   *
   * @param string   $question
   * @param string[] $options
   * @param int      $defaultIndex The default answer if the user just presses return. -1 = no default (empty input is
   *                               not allowed.
   * @param array    $secondColumn If specified, it contains the 2nd column for each option.
   * @param callable $validator    If specified, a function that validates the user's selection.
   *                               It receives the selected index (0 based) as argument and it should return `true`
   *                               if the selection is valid or an error message string if not.
   * @return int The selected index (0 based).
   */
  function menu ($question, array $options, $defaultIndex = -1, array $secondColumn = null,
                 callable $validator = null);

  /**
   * @return $this
   */
  function nl ();

  /**
   * @param string $text
   * @return $this
   */
  function say ($text);

  /**
   * Defines a tag for a custom color.
   *
   * @param string                        $name
   * @param OutputFormatterStyleInterface $style
   * @return $this
   */
  function setColor ($name, $style);

  /**
   * Outputs data in a tabular format.
   *
   * @param string[]      $headers
   * @param array         $data
   * @param int[]         $widths
   * @param string[]|null $align
   */
  function table (array $headers, array $data, array $widths, array $align = null);

  /**
   * @param string $text
   * @return $this
   */
  function title ($text);

  /**
   * Adds a warning message to be displayed later when done() is called.
   *
   * @param string $text
   * @return $this
   */
  function warn ($text);

  /**
   * @param string $text
   * @return $this
   */
  function write ($text);

  /**
   * @param string $text
   * @return $this
   */
  function writeln ($text = '');

}
