<?php


namespace Tapir;


class FilterCarsMapRequest extends MapRequest implements IPagination
{
    private array $get;

    private array $queryParams;

    private array $queryConditions;

    private array $mapRules =
        [
            'hash' => ['operator' => '=', 'field' => 'hash'],
            'brand' => ['operator' => '=', 'field' => 'brand'],
            'model' => ['operator' => '=', 'field' => 'model'],
            'vin' => ['operator' => '=', 'field' => 'vin'],
            'body_type' => ['operator' => '=', 'field' => 'body_type'],
            'engine_type' => ['operator' => '=', 'field' => 'engine_type'],
            'drive_type' => ['operator' => '=', 'field' => 'drive_type'],
            'gearbox_type' => ['operator' => '=', 'field' => 'gearbox_type'],
            'year_from' => ['operator' => '>=', 'field' => 'year'],
            'year_to' => ['operator' => '<=', 'field' => 'year'],
            'price_less' => ['operator' => '<=', 'field' => 'price'],
            'price_more' => ['operator' => '>=', 'field' => 'price'],
            'mileage_from' => ['operator' => '>=', 'field' => 'mileage'],
            'mileage_to' => ['operator' => '<=', 'field' => 'mileage'],
            'owner_count_from' => ['operator' => '>=', 'field' => 'owner_count'],
            'owner_count_to' => ['operator' => '<=', 'field' => 'owner_count'],
            'is_used' => ['operator' => '=', 'field' => 'is_used'],
        ];

    private Pagination $pagination;

    public function __construct($get)
    {
        $this->get = $get;
        $this->mapRequestToSql();
        $this->preparePagination();
    }

    private function mapRequestToSql()
    {
        $getKeys = array_keys($this->get);
        $this->queryConditions = [];
        $this->queryParams = [];
        foreach ($this->mapRules as $queryParamName => $rule) {
            if (in_array($queryParamName, $getKeys)) {
                $this->queryParams[$queryParamName] = $this->get[$queryParamName];
                $this->queryConditions[] = $rule['field'] . ' ' . $rule['operator'] . ' :' . $queryParamName;
            }
        }
    }

    private function preparePagination()
    {
        $page = 1;
        if (isset($this->get['page'])) {
            if ((int)$this->get['page'] > 0) {
                $page = (int)$this->get['page'];
            }
        }

        $this->pagination = new Pagination($page);
    }

    public function getSqlFilterParameters(): array
    {
        return $this->queryParams;
    }

    public function getSqlFilterConditions(): array
    {
        return $this->queryConditions;
    }

    public function getPagination(): Pagination
    {
        return $this->pagination;
    }
}
