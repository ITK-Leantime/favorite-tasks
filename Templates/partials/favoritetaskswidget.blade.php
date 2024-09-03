@props([
    'includeTitle' => true,
    'randomImage' => '',
    'totalTickets' => 0,
    'projectCount' => 0,
    'closedTicketsCount' => 0,
    'ticketsInGoals' => 0,
    'doneTodayCount' => 0,
    'totalTodayCount' => 0,
    'tickets' => []
])

<div>
    <div style="padding:10px 0px">
        <ul class="sortableTicketList">
            @foreach ($tickets as $ticket)
                <li>
                    <div class="ticketBox" style="cursor: initial;">
                        <div class="row">
                            <div class="col-md-10 titleContainer">
                                <small>{{ $ticket->projectName }}</small>
                                <br>
                                <strong>
                                    <a href="/#/tickets/showTicket/{{ $ticket->id }}">{{ $ticket->headline }}</a>
                                </strong>
                            </div>
                            <div class="col-md-2">
                                <a href="/?tab=timesheet#/tickets/showTicket/{{ $ticket->id }}" onclick="jQuery(this).addClass('go')" class="favoriteIssue favoriteStar margin-right tw-mr-[5px]" data-tippy-content="Favorite-issue">
                                    <i class="fa-regular fa-clock"></i>
                                </a>
                                <i class="fa-solid fa-star"></i>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
