<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\ValueObject;

enum MessageStatus: string
{
    case Accepted = 'accepted';
    case Delivered = 'delivered';
    case DeliveryError = 'delivery error';
    case EmptyText = 'text is empty';
    case IncorrectId = 'incorrect id';
    case InvalidPhoneNumber = 'invalid mobile phone';
    case InvalidScheduleTimeFormat = 'invalid schedule time format';
    case InvalidSenderName = 'sender address invalid';
    case InvalidStatusQueueName = 'invalid status queue name';
    case InvalidWapUrl = 'wapurl invalid';
    case NotEnoughBalance = 'not enough balance';
    case Queued = 'queued';
    case SmscDelivered = 'smsc submit';
    case SmscRejected = 'smsc reject';
}
