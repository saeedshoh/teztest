<?php


namespace App\Modules\Orders\Services;


class OrderStatusService
{
    public CONST ORDER_STATUS_IN_PROCESS = 1;
    public CONST ORDER_STATUS_SENT = 2;
    public CONST ORDER_STATUS_PERFORMED = 3;
    public CONST ORDER_STATUS_ACCEPTED = 4;
    public CONST ORDER_STATUS_NOT_COMPLETED = 5;
    public CONST ORDER_STATUS_CANCELED = 6;
    public CONST ORDER_STATUS_RETURNED = 7;
    public CONST ORDER_STATUS_DENIED = 8;
    public CONST ORDER_STATUS_ERROR_PAYMENT = 9;

}
