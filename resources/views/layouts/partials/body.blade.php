<div class="back-button">
    <a href="{{ route('products.index') }}" class="btn back-btn">
        Show Products
    </a>
    
    <a href="{{route('categories.index') }}" class="btn back-btn">
        Show  Category
    </a>
        
    <a href="{{route('notifications.index') }}" class="btn back-btn">
        Show Notification
    </a>    

    @if (auth()->user()?->isAdmin())
    <a href="{{route('suppliers.index') }}" class="btn back-btn">
        Show Suppliers
    </a>    

    <a href="{{route('stock-movements.index') }}" class="btn back-btn">
        Show Stock-Movements
    </a>    
    @endif
</div>


