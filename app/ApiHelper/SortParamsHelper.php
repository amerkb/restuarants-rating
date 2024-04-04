<?php

namespace App\ApiHelper;

class SortParamsHelper
{
    public string $table;

    public string $relation;

    public string $join_column;

    public string $order_column;

    public bool $is_related = false;

    public function getIsRelated(): bool
    {
        return $this->is_related;
    }

    public function setIsRelated(bool $is_related): void
    {
        $this->is_related = $is_related;
    }

    public function getOrderColumn(): string
    {
        return $this->order_column;
    }

    public function setOrderColumn(string $order_column): void
    {
        $this->order_column = $order_column;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    public function getRelation(): string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): void
    {
        $this->relation = $relation;
    }

    public function getJoinColumn(): string
    {
        return $this->join_column;
    }

    public function setJoinColumn(string $join_column): void
    {
        $this->join_column = $join_column;
    }

    public static function getSortParams(string $sortString): SortParamsHelper
    {
        $sortParams = new SortParamsHelper();
        if ($sortString != '') {
            $sortParamsArray = explode('.', $sortString);
            if (is_array($sortParamsArray) && count($sortParamsArray) > 1) {
                $sortParams->setIsRelated(true);
            }
            $sortParams->setTable($sortParamsArray[0]);
            $sortParams->setRelation($sortParamsArray[0].'.id');
            $sortParams->setJoinColumn(substr($sortParamsArray[0], 0, -1).'_id');
            $sortParams->setOrderColumn($sortString);
        }

        return $sortParams;
    }
}
