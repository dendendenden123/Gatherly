<!--PURPOSE:  This component is responsible for rendering the pagination controls for a given dataset.
  It checks if the dataset has multiple pages and displays the appropriate navigation links/buttons. -->

<!-- Example Usage: < x - pagination :data="//data here" /> -->

@if ($data->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
        <div class="text-sm text-gray-500">
            Showing <span class="font-medium">{{ $data->firstItem() }}</span> to <span
                class="font-medium">{{ $data->lastItem() }}</span>
        </div>
        <div class="pagination flex space-x-2">
            <!-- previous page link -->
            @if($data->onFirstPage())
                <button
                    class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-400 bg-gray-100 cursor-not-allowed"
                    disabled>
                    Previous
                </button>
            @else
                <a href="{{ $data->previousPageUrl() }}">
                    <button
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Previous
                    </button>
                </a>
            @endif

            <!-- Next Page Link -->
            @if($data->hasMorePages())
                <a href="{{ $data->nextPageUrl() }}">
                    <button
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Next
                    </button>
                </a>
            @else
                <button
                    class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-400 bg-gray-100 cursor-not-allowed"
                    disabled>
                    Next
                </button>
            @endif
        </div>
    </div>
@endif