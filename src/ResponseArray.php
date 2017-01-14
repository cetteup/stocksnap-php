<?php
namespace Diza\Stocksnap;

class ResponseArray extends \ArrayObject
{
  private $headers;

  const NEXT = 'nextPage';

  const TOTAL = 'count';
  const PER_PAGE = 40;

  public function __construct($headers, $body)
  {
      $this->headers = $headers;

      parent::__construct($body);
  }

  public function total_pages()
  {
      $total = $this->total_objects();

      return (int) ceil($total / self::PER_PAGE);
  }

  public function total_objects()
  {
      $total = 0;
      if (!empty($this[self::TOTAL]) && is_int($this[self::TOTAL])) {
          $total = (int) $this[self::TOTAL];
      }

      return $total;
  }

  public function current_page()
  {
      if (isset($this[self::NEXT])) {
          $page = $this[self::NEXT] - 1;
      }

      return $page;
  }
}
?>
