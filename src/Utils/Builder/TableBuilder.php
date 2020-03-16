<?php

namespace App\Utils\Builder;

class TableBuilder
{
    private $table;
    private $thead = [];
    private $tbody = [];
    private $tfoot = [];

    public function addHeader(array $header)
    {
        $this->thead[] = $header;
        return $this;
    }

    public function addRow(array $row)
    {
        $this->tbody[] = $row;
        return $this;
    }

    public function addRows(array $rows)
    {
        $this->tbody = $rows;
        return $this;
    }

    public function addFooter(array $footer)
    {
        $this->tfoot[] = $footer;
        return $this;
    }

    public function build()
    {
        $this->table = "<table>";

        $this->table .= $this->buildRows($this->tbody);

        if(!empty($this->thead)) {
            $this->table .= $this->buildRows($this->thead, 'thead', 'th');
        }

        if(!empty($this->tfoot)) {
            $this->table .= $this->buildRows($this->tfoot, 'tfoot');
        }

        $this->table .= "</table>";

        return $this;
    }

    public function getTable()
    {
        return $this->table;
    }

    protected function buildRows($rows, $container = 'tbody', $col = "td")
    {
        $html = "<".$container.">";
        foreach ($rows as $row) {
            $html .= "<tr>";
            foreach ($row as $value) {
                $html .= "<".$col.">".$value."</".$col.">";
            }
            $html .= "</tr>";
        }
        $html .= "</".$container.">";

        return $html;
    }
}