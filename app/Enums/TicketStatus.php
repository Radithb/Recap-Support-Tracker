<?php

namespace App\Enums;

enum TicketStatus: string
{
    case OPEN = 'Open';
    case PENDING = 'Pending';
    case PROSES = 'Proses';
    case PREVIEW = 'In Preview';
    case DONE = 'Done';
}
