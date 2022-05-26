@if(isset($audit->new_values[$attribute]))
    @if(isset($audit->old_values[$attribute])){{$audit->old_values[$attribute] }}@endif  <i class="bx bxs-right-arrow"></i>  <b>{{$audit->new_values[$attribute]}}</b>
@endif
