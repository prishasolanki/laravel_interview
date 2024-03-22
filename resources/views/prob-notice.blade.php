@if(remainPrice() != 0)
    <div>
        <span class="text-danger">Sum of all prizes probability must be 100%.Currently its {{ currentPrice() }} % You
            have yet
            to add {{ remainPrice() }} % to the prize.</span>

    </div>
@endif

{{-- TODO: add Message logic here --}}
