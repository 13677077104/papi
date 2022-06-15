<?php

namespace App\Common;

interface ModelInterface
{
    public function create($data);

    public function query($where): array;

    public function queryByPage($where, int $page, int $pageSize): array;

    public function updateById($id, $data): bool;

    public function deleteById($id): bool;


}