<div class="d-inline p-1 rounded" >
        @if (\Cart::getContent()->count()>0)
        <span  style="background: #9c27b0; color:white ; border-radius: 25px; font-weight:700" class="px-2 py-1 " >
                {{\Cart::getContent()->count() }}
        </span> 
        @endif

        
        
</div>
