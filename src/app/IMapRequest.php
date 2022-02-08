<?php


namespace Tapir;


interface IMapRequest
{
    public function getSqlFilterParameters(): array;

    public function getSqlFilterConditions(): array;
}
