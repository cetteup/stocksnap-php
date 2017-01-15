<?php
namespace Diza\Stocksnap;

class ResponseArray extends \ArrayObject
{
    private $headers;

    const NEXT = 'nextPage';

    const TOTAL = 'count';
    const PER_PAGE = 40;
    const ORDER_BY = 'sortBy';
    const SORT_ORDER = 'sortOrder';

    public function __construct($headers, $body)
    {
        $this->headers = array_merge($headers,$this->extract_header_info($body));

        parent::__construct($body['results']);
    }

    private function extract_header_info($body)
    {
        $move_to_header = [];

        if (isset($body[self::ORDER_BY])) {
            $move_to_header[self::ORDER_BY] = [$body[self::ORDER_BY]];
        } else {
            $move_to_header[self::ORDER_BY] = [strtolower(explode('Selected',explode('sidebar','sidebarSortBySelected')[1])[0])];
        }

        if (isset($body[self::SORT_ORDER])) {
            $move_to_header[self::SORT_ORDER] = [$body[self::SORT_ORDER]];
        } else {
            $move_to_header[self::SORT_ORDER] = [strtolower(explode('Selected',explode('sidebar','sidebarSortOrderSelected')[1])[0])];
        }

        if (isset($body[self::TOTAL])) {
            $move_to_header[self::TOTAL] = [(int) $body[self::TOTAL]];
        }

        $move_to_header[self::NEXT] = [(int) $body[self::NEXT]];

        return $move_to_header;
    }

    public function total_pages()
    {
        $total = $this->total_objects();

        return (int) ceil($total / self::PER_PAGE);
    }

    public function total_objects()
    {
        $total = 0;
        if (!empty($this->headers[self::TOTAL]) && is_array($this->headers[self::TOTAL])) {
            $total = (int) $this->headers[self::TOTAL][0];
        }

        return $total;
    }

    public function current_page()
    {
        if (isset($this->headers[self::NEXT])) {
            $page = $this->headers[self::NEXT][0] - 1;
        }

        return $page;
    }
}
?>
