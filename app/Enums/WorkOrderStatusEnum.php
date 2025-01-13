<?php

namespace App\Enums;

enum WorkOrderStatusEnum: string
{
    case PENDING = 'pending';
    case EXPIRED = 'expired';
    case IN_PROGRESS = 'in_progress';
    case APPROVED = 'approved';
    case DECLINED = 'declined';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
    case PAID = 'paid';
}
