<div class="w-full mx-auto">
    <div class="space-y-4">
        @foreach($sections as $section)
            <div class="border rounded-lg overflow-hidden">
                <button class="w-full text-left p-4 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:bg-gray-200" onclick="toggleAccordion({{$loop->index}})">
                    <h2 class="font-medium text-lg">{{$section["name"]}}</h2>
                </button>
                <div id="accordion-{{$loop->index}}" class="p-4 hidden bg-white">
                    <p>{!! $section["content"] !!}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
<script>
    function toggleAccordion(key) {
        const content = document.getElementById(`accordion-${key}`);
        content.classList.toggle('hidden');
    }
</script>
