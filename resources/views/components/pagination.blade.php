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
                <a href="{{ $data->previousPageUrl() }}" class="previous-button">
                    <button
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Previous
                    </button>
                </a>
            @endif

            <!-- Next Page Link -->
            @if($data->hasMorePages())
                <a href="{{ $data->nextPageUrl() }}" class="next-button">
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
<script>
    $(document).ready(() => {
        const containerClass = @json($containerClass);
        let ajaxRequest = null;
        let debounceTimer = null;

        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            const url = $(this).attr('href');

            // Clear the debounce timer if user clicks again quickly
            clearTimeout(debounceTimer);

            // Set a small delay before making the request (debounce)
            debounceTimer = setTimeout(() => {
                // Abort previous request if still active
                if (ajaxRequest) {
                    ajaxRequest.abort();
                }

                ajaxRequest = $.ajax({
                    url: url,
                    type: 'GET',
                    data: $('form').serialize(),
                    success: function (data) {
                        $('.' + containerClass).html(data.list);
                    },
                    error: function (xhr, status, error) {
                        if (status !== 'abort') {
                            console.error('Pagination error:', error);
                        }
                    }
                });
            }, 300); // debounce delay in ms
        });
    });
</script>