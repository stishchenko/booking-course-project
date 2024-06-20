<?php

namespace App\Dtos;

class OrderDto
{
    public int $id;
    public string $company;
    public string $service;
    public string $employee;
    public float $price;
    public int $duration;
    public string $date;
    public string $startTime;
    public string $clientName;
    public string $clientPhone;
}
