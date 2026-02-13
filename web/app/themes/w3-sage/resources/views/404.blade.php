@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (! have_posts())

  
        <div class="max-w-4xl mx-auto">
            <!-- 404 Error Section -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-accent-100 to-accent-50 mb-6 animate-float">
                    <i class="fas fa-search text-accent-600 text-3xl"></i>
                </div>
                
                <h1 class="text-6xl md:text-8xl font-bold text-primary-400 mb-4 animate-pulse-gentle">404</h1>
                <h2 class="text-2xl md:text-3xl font-bold text-primary-800 mb-4">{!! __('Page Not Found','sage') !!}</h2>
                <p class="text-lg text-primary-600 max-w-2xl mx-auto mb-8">
                    {!! __('Oops! The page you’re looking for seems to have wandered off into the digital wilderness. But don’t worry - you can search our blog or explore our popular articles below.', 'sage') !!}

                </p>
                
                <!-- Search Form -->
                <div class="max-w-2xl mx-auto mb-12">
                    <div class="bg-white p-8 dark:bg-gray-800/50 rounded-2xl p-1 search-shadow">
                      {!! get_search_form(false) !!}
                        
                    </div>
                    
                    <div class="mt-4 text-sm text-primary-500">
                        <p>{!! __('Try searching for:','sage') !!} <span class="font-medium text-accent-600">"développement web"</span>, <span class="font-medium text-accent-600">"WordPress"</span>, ou <span class="font-medium text-accent-600">"SEO"</span></p>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="flex flex-wrap justify-center gap-4 mb-12">
                    <a href="/" class="px-6 py-3 bg-white  dark:bg-gray-800/50 no-underline border border-primary-200 text-primary-700 rounded-xl hover:border-accent-400 hover:text-accent-700 transition-all duration-300 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30" height="30"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M277.8 8.6c-12.3-11.4-31.3-11.4-43.5 0l-224 208c-9.6 9-12.8 22.9-8 35.1S18.8 272 32 272l16 0 0 176c0 35.3 28.7 64 64 64l288 0c35.3 0 64-28.7 64-64l0-176 16 0c13.2 0 25-8.1 29.8-20.3s1.6-26.2-8-35.1l-224-208zM240 320l32 0c26.5 0 48 21.5 48 48l0 96-128 0 0-96c0-26.5 21.5-48 48-48z"/></svg>
                        <span>{!! __('Go to Homepage','sage') !!}</span>
                    </a>
                    <a href="/articles/" class="px-6 py-3 bg-white  dark:bg-gray-800/50 no-underline border border-primary-200 text-primary-700 rounded-xl hover:border-accent-400 hover:text-accent-700 transition-all duration-300 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="30" height="30"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M320 205.3L320 514.6L320.5 514.4C375.1 491.7 433.7 480 492.8 480L512 480L512 160L492.8 160C450.6 160 408.7 168.4 369.7 184.6C352.9 191.6 336.3 198.5 320 205.3zM294.9 125.5L320 136L345.1 125.5C391.9 106 442.1 96 492.8 96L528 96C554.5 96 576 117.5 576 144L576 496C576 522.5 554.5 544 528 544L492.8 544C442.1 544 391.9 554 345.1 573.5L332.3 578.8C324.4 582.1 315.6 582.1 307.7 578.8L294.9 573.5C248.1 554 197.9 544 147.2 544L112 544C85.5 544 64 522.5 64 496L64 144C64 117.5 85.5 96 112 96L147.2 96C197.9 96 248.1 106 294.9 125.5z"/></svg>
                        <span>{!! __('Browse All Articles','sage') !!}</span>
                    </a>
                    <a href="/accompagnement/" class="px-6 py-3 bg-white dark:bg-gray-800/50 no-underline border border-primary-200 text-primary-700 rounded-xl hover:border-accent-400 hover:text-accent-700 transition-all duration-300 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="30" height="30"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M112 128C85.5 128 64 149.5 64 176C64 191.1 71.1 205.3 83.2 214.4L291.2 370.4C308.3 383.2 331.7 383.2 348.8 370.4L556.8 214.4C568.9 205.3 576 191.1 576 176C576 149.5 554.5 128 528 128L112 128zM64 260L64 448C64 483.3 92.7 512 128 512L512 512C547.3 512 576 483.3 576 448L576 260L377.6 408.8C343.5 434.4 296.5 434.4 262.4 408.8L64 260z"/></svg>
                        <span>{!! __('Contact Support','sage') !!}</span>
                    </a>
                </div>
            </div>

            <!-- Popular Articles Section -->
            <div class="mb-16">
                <h3 class="text-2xl font-bold text-primary-800 mb-8 text-center font-serif">{!! __('Popular Articles You Might Like','sage') !!}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Article Card 1 -->
                    <div class="bg-white rounded-2xl overflow-hidden border border-primary-100 card-hover">
                        <div class="h-48 overflow-hidden">
                            <img 
                                src="https://picsum.photos/400/300?random=1" 
                                alt="Modern web development techniques and best practices" 
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                                loading="lazy"
                            >
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                <span class="px-3 py-1 bg-accent-100 text-accent-700 text-xs font-semibold rounded-full">Development</span>
                                <span class="ml-3 text-sm text-primary-500">12 min read</span>
                            </div>
                            <h4 class="text-lg font-bold text-primary-800 mb-2">Modern Web Development in 2024</h4>
                            <p class="text-primary-600 text-sm mb-4">Learn the latest techniques and tools for building fast, responsive websites.</p>
                            <a href="javascript:void(0)" onclick="navigateTo('article1')" class="text-accent-600 font-medium text-sm hover:text-accent-700 transition-colors flex items-center">
                                Read Article <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Article Card 2 -->
                    <div class="bg-white rounded-2xl overflow-hidden border border-primary-100 card-hover">
                        <div class="h-48 overflow-hidden">
                            <img 
                                src="https://picsum.photos/400/300?random=2" 
                                alt="UI/UX design principles for better user engagement" 
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                                loading="lazy"
                            >
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">Design</span>
                                <span class="ml-3 text-sm text-primary-500">8 min read</span>
                            </div>
                            <h4 class="text-lg font-bold text-primary-800 mb-2">UI/UX Principles That Convert</h4>
                            <p class="text-primary-600 text-sm mb-4">Essential design principles to improve user engagement and conversion rates.</p>
                            <a href="javascript:void(0)" onclick="navigateTo('article2')" class="text-accent-600 font-medium text-sm hover:text-accent-700 transition-colors flex items-center">
                                Read Article <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Article Card 3 -->
                    <div class="bg-white rounded-2xl overflow-hidden border border-primary-100 card-hover">
                        <div class="h-48 overflow-hidden">
                            <img 
                                src="https://picsum.photos/400/300?random=3" 
                                alt="SEO optimization strategies for content creators" 
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                                loading="lazy"
                            >
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">SEO</span>
                                <span class="ml-3 text-sm text-primary-500">15 min read</span>
                            </div>
                            <h4 class="text-lg font-bold text-primary-800 mb-2">SEO for Content Creators</h4>
                            <p class="text-primary-600 text-sm mb-4">Advanced SEO strategies to help your content rank higher in search results.</p>
                            <a href="javascript:void(0)" onclick="navigateTo('article3')" class="text-accent-600 font-medium text-sm hover:text-accent-700 transition-colors flex items-center">
                                Read Article <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Newsletter Section -->
            <div class="bg-gradient-to-r from-accent-50 to-blue-50 rounded-2xl p-8 md:p-12 mb-12 border border-accent-100">
                <div class="max-w-2xl mx-auto text-center">
                    <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-envelope-open-text text-accent-600 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-primary-800 mb-4 font-serif">Never Miss an Update</h3>
                    <p class="text-primary-600 mb-6">Subscribe to our newsletter and get the latest articles, tutorials, and insights delivered directly to your inbox.</p>
                    
                    <form id="newsletter-form" class="max-w-md mx-auto">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <input 
                                type="email" 
                                placeholder="Your email address" 
                                class="flex-1 px-4 py-3 rounded-xl border border-primary-200 focus:border-accent-500 focus:ring-2 focus:ring-accent-200 focus:outline-none"
                                required
                            >
                            <button 
                                type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-accent-500 to-accent-600 text-white font-semibold rounded-xl hover:from-accent-600 hover:to-accent-700 transition-all duration-300 transform hover:-translate-y-0.5"
                            >
                                Subscribe
                            </button>
                        </div>
                        <p class="text-xs text-primary-500 mt-3">No spam, unsubscribe at any time.</p>
                    </form>
                </div>
            </div>
        </div>
  @endif
@endsection
