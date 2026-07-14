<?php

namespace App\Enums;

enum TicketStatus: string
{
    case OPEN = 'Open';
    case PENDING = 'Pending';
    case PROSES = 'Proses';
    case DONE = 'Done';
}
