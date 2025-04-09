<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <!-- Usuarios (Home cooks) -->
            <div class="bg-purple-50 p-2 rounded-full shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-center">
                    <svg class="w-8 h-8 text-purple-400 mr-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd" d="M12.0212 2.37541c.2069.29981.2344.6884.0718 1.01435-.0835.16728-.1286.49646-.0866.81839.0345.26443.1525.51845.3564.72235.3798.37974.9446.46622 1.4086.25366.5022-.23 1.0957-.0094 1.3256.49272.0358.07797.0606.15815.0752.23883.0722.36885-.0676.76315-.391.99974-.067.04901-.1315.10409-.1929.16547-.6377.63769-.6377 1.67158 0 2.30927.6377.63771 1.6716.63771 2.3093 0 .1104-.11046.2008-.23148.2721-.35918.2649-.47416.8598-.65023 1.3401-.3966.4802.25363.6702.84422.428 1.33031-.1068.21428-.1459.45618-.1151.69208.033.2531.146.4962.3412.6915.265.265.622.3806.9709.3452.0473-.0048.095-.0062.1425-.0043.111.0047.5252-.0071.7534-.0158.2865-.0108.5639.1018.7617.3093.1978.2075.2971.4899.2726.7756-.1945 2.2647-1.1592 4.478-2.8921 6.2109-3.9053 3.9053-10.23692 3.9053-14.14216 0-3.90524-3.9052-3.90524-10.23686 0-14.1421C6.727 3.13084 8.88362 2.17056 11.0983 1.94837c.3624-.03636.716.12723.9229.42704ZM8.65695 8.41498c-.55229 0-1 .44771-1 1 0 .55228.44771 1.00002 1 1.00002h.01c.55228 0 1-.44774 1-1.00002 0-.55229-.44772-1-1-1h-.01ZM7.27106 12c-.55229 0-1 .4478-1 1 0 .5523.44771 1 1 1h.01c.55228 0 1-.4477 1-1 0-.5522-.44772-1-1-1h-.01Zm7.68744 1.9157c-.5523 0-1 .4477-1 1s.4477 1 1 1h.01c.5523 0 1-.4477 1-1s-.4477-1-1-1h-.01ZM11 16c-.5523 0-1.00004.4478-1.00004 1 0 .5523.44774 1 1.00004 1h.01c.5523 0 1-.4477 1-1 0-.5522-.4477-1-1-1H11Z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <div class="text-2xl font-bold text-purple-400" 
                            data-counter="{{ \App\Models\User::count() }}" 
                            data-suffix="K">
                            {{ \App\Models\User::count() }}
                        </div>
                        <p class="text-md text-gray-600">Cocineros</p>
                    </div>
                </div>
            </div>
            
            <!-- Recetas confiables -->
            <div class="bg-blue-50 p-2 rounded-full shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-blue-400 mr-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                      </svg>                                         
                    <div>
                        <div class="text-2xl font-bold text-blue-400" 
                            data-counter="{{ \App\Models\Recipe::count() }}" 
                            data-suffix="K">
                            {{ \App\Models\Recipe::count() }}
                        </div>
                        <p class="text-md text-gray-600">Recetas Caseras</p>
                    </div>
                </div>
            </div>

            <!-- Likes en las recetas -->
            <div class="bg-red-50 p-2 rounded-full shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-red-400 mr-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>                       
                    <div>
                        <div class="text-2xl font-bold text-red-400" 
                            data-counter="{{ \App\Models\Recipe::sum('likes') }}" 
                            data-suffix="M">
                            {{ \App\Models\Recipe::sum('likes') }}M
                        </div>
                        <p class="text-md text-gray-600">Me gusta</p>
                    </div>
                </div>
            </div>

            <!-- Categorías -->
            <div class="bg-green-50 p-2 rounded-full shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-400 mr-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M8.9884 3.21891c3.0076.24714 5.945 1.51873 8.2417 3.8154 2.269 2.26907 3.5376 5.16369 3.806 8.13349.1181 1.3063-.817 2.3512-1.9748 2.5974-.3781.0805-.7426.0766-1.0826.0053-.0526-.9449-.1322-1.9863-.2259-2.7243-.2666-2.0994-1.0578-3.9824-2.805-5.72956-1.7428-1.74283-3.6864-2.60074-5.82006-2.9026-.44367-.06276-1.6162-.18893-2.69208-.26801-.06233-.34562-.05329-.7147.04516-1.0954.2799-1.0824 1.27852-1.93272 2.50758-1.83172Z"/>
                        <path fill="currentColor" fill-rule="evenodd" d="M15.7687 15.2981c.0789.6213.1481 1.4924.1977 2.3181L4.6757 20.8741c-.34909.1007-.72534.0042-.98281-.2521-.25747-.2564-.35564-.6322-.25642-.9817L6.69176 8.17203c.89043.07337 1.79027.17058 2.15583.2223 1.73781.24585 3.27301.92348 4.68601 2.33657 1.4054 1.4054 2.0192 2.8665 2.2351 4.5672Zm-4.3548-4.5789c-.0238-.5518-.4904-.97977-1.0422-.95597-.55178.02381-.97978.49037-.95598 1.04217l.00047.0108c.0238.5518.4904.9798 1.04221.956.5517-.0238.9797-.4904.9559-1.0422l-.0004-.0108Zm3.0873 3.0873c-.0238-.5518-.4904-.9798-1.0422-.956-.5518.0238-.9798.4904-.956 1.0422l.0005.0108c.0238.5518.4903.9798 1.0421.956.5518-.0238.9798-.4904.956-1.0421l-.0004-.0109Zm-4.58671 1.4994c-.02377-.5517-.49034-.9798-1.04211-.956-.55177.0238-.9798.4903-.95603 1.0421l.00046.0108c.02377.5518.49034.9798 1.04211.9561.55178-.0238.97981-.4904.95604-1.0421l-.00047-.0109Z" clip-rule="evenodd"/>
                    </svg>                      
                    <div>
                        <div class="text-2xl font-bold text-green-400" 
                            data-counter="{{ \App\Models\Category::count() }}"
                            data-suffix="K">
                            {{ \App\Models\Category::count() }} 
                        </div>
                        <p class="text-md text-gray-600">Categorías</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('[data-counter]');
        
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-counter');
            const suffix = counter.getAttribute('data-suffix') || '';
            const duration = 2000; // 2 segundos
            const start = 0;
            const increment = target / (duration / 16); // 60fps
            
            let current = start;
            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.textContent = Math.floor(current) + suffix;
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target + suffix;
                }
            };
            
            // Iniciar animación cuando el elemento es visible
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    updateCounter();
                    observer.unobserve(counter);
                }
            });
            
            observer.observe(counter);
        });
    });
</script>
@endpush
