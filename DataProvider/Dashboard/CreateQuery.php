<?php
/*
 * Copyright (c) 2021 AxProd
 * See https://github.com/alex-dev-github/magento2-monday/blob/main/LICENSE for license details.
 */

namespace AxProd\Monday\DataProvider\Dashboard;

use AxProd\Monday\DataProvider\QueryInterface;

/**
 * Class CreateQuery
 * @author Alexandr Novikov <https://github.com/alex-dev-github/magento2-monday>
 * @package AxProd\Monday\DataProvider\Dashboard
 */
class CreateQuery implements QueryInterface
{
    /**
     * @var array
     */
    private array $dashboards;

    /**
     * CreateQuery constructor.
     * @param array $dashboards
     */
    public function __construct(array $dashboards)
    {
        $this->dashboards = $dashboards;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        $boards = '';

        foreach($this->dashboards as $index => $name) {
            $boards .= <<<QUERY
                b{$index}: create_board (board_name: "{$name}", board_kind: public) {
                    id,
                    name
                }
             QUERY;
        }

        return <<<QUERY
            mutation {
                $boards
            }
        QUERY;
    }
}
