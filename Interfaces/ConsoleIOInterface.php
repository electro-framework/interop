<?php
namespace Electro\Interfaces;

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
   * Displays an operation cancelation message and aborts execution.
   * <p>If the input stream is not interactive, no message will be displayed.
   *
   * @param string $message [optional]
   */
  function cancel ($message = 'Canceled');

  /**
   * Clears the display.
   *
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
   * @param string $text [optional]
   * @param int    $status Status exit code.
   */
  function done ($text = '', $status = 0);

  /**
   * Prints an error message and stops execution. Use only on commands, not on tasks.
   *
   * @param string $text   The message.
   * @param int    $width  Error box width.
   * @param int    $status Status exit code.
   */
  function error ($text, $width = 0, $status = 1);

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
   * @param OutputInterface $output
   * @return mixed
   */
  function setOutput (OutputInterface $output);

  /**
   * Sets the indentation level for all lines from this point on.
   *
   * @param int $level
   * @return $this
   */
  function indent ($level = 0);

  /**
   * Presents a list to the user, from which he/she must select an item.
   *
   * <p>If the input stream is not interactive, the menu will not be displayed and the default value will be
   * immediately returned.
   *
   * @param string   $question
   * @param string[] $options      A list of options to display (numeric keys only).
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
   * Alias of `writeln()`.
   *
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
   * @param string[]      $headers A list of table column headers.
   * @param array         $data    A bidimensional array of data for the table body.
   * @param int[]         $widths  Each width that is 0 will be assigned the remaining horizontal space on the terminal,
   *                               divided by the number of columns set to 0.
   * @param string[]|null $align   A list of column alignments; values: 'L'|'R'|'C'
   */
  function table (array $headers, array $data, array $widths, array $align = null);

  /**
   * Gets or sets information about the terminal window dimensions (a list of width and height).
   *
   * @param array|null $terminalSize [optiona] If given, saves the terminar dimensions for later retrieval.
   *                                 If not given, returns the previously set dimensions.
   * @return array
   */
  public function terminalSize (array $terminalSize = null);

  /**
   * Writes a title line (with specific formatting) followed by a blank line.
   *
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
   * Writes text, with support for formatting tags.
   *
   * @param string $text
   * @return $this
   */
  function write ($text);

  /**
   * Like {@see write} but appends a line return to the output.
   *
   * @param string $text
   * @return $this
   */
  function writeln ($text = '');

}
