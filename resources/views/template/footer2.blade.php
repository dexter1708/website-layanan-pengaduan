
    <!-- Supported By Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Didukung Oleh</h2>
            <p class="text-gray-600 text-lg mb-12">Lembaga yang bekerjasama dengan SAPA</p>

            <div class="relative">
                <!-- Tombol geser kiri (dihapus) -->
                <!-- <button id="scroll-left" ...>...</button> -->

                <!-- Kontainer scroll logo -->
                <div id="scroll-container"
                    class="mx-auto max-w-4xl overflow-x-auto flex space-x-12 px-4 py-4 scroll-smooth scrollbar-hide justify-center">
                    @foreach (['image2.png', 'image3.png', 'image4.png', 'image5.png'] as $img)
                        <div class="flex-shrink-0 w-28 h-28 flex items-center justify-center">
                            <img src="{{ asset('assets/' . $img) }}" alt="logo"
                                class="max-h-full object-contain">
                        </div>
                    @endforeach
                </div>

                <!-- Tombol geser kanan (dihapus) -->
                <!-- <button id="scroll-right" ...>...</button> -->
            </div>
        </div>

        <!-- Hide Scrollbar Styling -->
        <style>
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }

            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>

        <!-- Script Geser -->
        <script>
            const scrollContainer = document.getElementById('scroll-container');
            document.getElementById('scroll-left').addEventListener('click', () => {
                scrollContainer.scrollBy({
                    left: -200,
                    behavior: 'smooth'
                });
            });
            document.getElementById('scroll-right').addEventListener('click', () => {
                scrollContainer.scrollBy({
                    left: 200,
                    behavior: 'smooth'
                });
            });
        </script>
    </section>
