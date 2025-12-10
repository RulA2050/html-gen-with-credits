@extends('layouts.app')

@section('title', 'Editor Halaman - ' . $generation->title)

@section('content')
<div
    class="h-[calc(100vh-64px)] -m-4 bg-slate-950 text-slate-200 overflow-hidden flex flex-col"
    x-data="htmlEditor({
        html: @js($generation->html_full ?? ''),
        css: @js($generation->css_raw ?? ''),
        js: @js($generation->js_raw ?? ''),
        library: @js($generation->library ?? ''),
        schema: @js($schema),
        headCssUrls: @js($headCssUrls),
        headJsUrls: @js($headJsUrls),
        bodyJsUrls: @js($bodyJsUrls),
    })"
    x-init="init()"
    x-cloak
>
    {{-- TOP BAR: Title & Actions --}}
    <div class="h-16 border-b border-slate-800 bg-slate-900/50 flex items-center justify-between px-6 shrink-0 z-20 backdrop-blur-sm">
        <div class="flex items-center gap-4">
            <div class="p-2 bg-orange-500/10 rounded-lg">
                <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h1 class="text-sm font-bold text-white tracking-wide">{{ $generation->title }}</h1>
                <div class="flex items-center gap-2 text-[10px] text-slate-400">
                    <span class="uppercase font-semibold tracking-wider text-orange-400">{{ strtoupper($generation->library) }}</span>
                    <span>&bull;</span>
                    <span>Terakhir diubah {{ $generation->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        {{-- Device Toggles --}}
        <div class="hidden md:flex bg-slate-800 rounded-lg p-1 border border-slate-700/50">
            <button @click="setDevice('desktop')" :class="device === 'desktop' ? 'bg-slate-600 text-white shadow-sm' : 'text-slate-400 hover:text-slate-200'" class="p-1.5 rounded transition-all" title="Desktop View">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </button>
            <button @click="setDevice('tablet')" :class="device === 'tablet' ? 'bg-slate-600 text-white shadow-sm' : 'text-slate-400 hover:text-slate-200'" class="p-1.5 rounded transition-all" title="Tablet View">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
            </button>
            <button @click="setDevice('mobile')" :class="device === 'mobile' ? 'bg-slate-600 text-white shadow-sm' : 'text-slate-400 hover:text-slate-200'" class="p-1.5 rounded transition-all" title="Mobile View">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
            </button>
        </div>

        <div class="flex items-center gap-3">
            <span class="text-[10px] text-slate-500 hidden lg:inline">
                {{ !empty($activeAssetNames) ? implode(', ', $activeAssetNames) : 'No CDN' }}
            </span>
            <button type="button" @click="$refs.mainForm.submit()" class="bg-orange-600 hover:bg-orange-500 text-white px-5 py-2 rounded-lg text-xs font-bold transition-colors shadow-lg shadow-orange-900/20 flex items-center gap-2">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                Simpan Perubahan
            </button>
        </div>
    </div>

    {{-- MAIN WORKSPACE --}}
    <div class="flex-1 flex overflow-hidden">

        {{-- LEFT: Canvas / Live Preview --}}
        <div class="flex-1 bg-slate-950/50 relative overflow-hidden flex flex-col items-center justify-center p-8 transition-all duration-300 pattern-dots">
            {{-- Background Pattern --}}
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>

            <div
                class="bg-white transition-all duration-500 ease-in-out shadow-2xl relative"
                :class="{
                    'w-full h-full rounded-md': device === 'desktop',
                    'w-[768px] h-[90%] rounded-[2rem] border-[8px] border-slate-800': device === 'tablet',
                    'w-[375px] h-[90%] rounded-[2.5rem] border-[10px] border-slate-800': device === 'mobile'
                }"
            >
                {{-- Notch for mobile --}}
                <div x-show="device === 'mobile'" class="absolute top-0 left-1/2 -translate-x-1/2 h-6 w-32 bg-slate-800 rounded-b-xl z-10"></div>

                <iframe id="previewFrame" class="w-full h-full bg-white transition-all" :class="{'rounded-md': device === 'desktop', 'rounded-[1.5rem]': device !== 'desktop'}"></iframe>

                {{-- Loading indicator for Tailwind processing --}}
                <div x-show="isProcessing" x-transition class="absolute inset-0 bg-white/80 flex items-center justify-center rounded-md">
                    <div class="flex flex-col items-center">
                        <svg class="animate-spin h-8 w-8 text-orange-500 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-sm text-slate-600">Memproses Tailwind CSS...</p>
                    </div>
                </div>

                {{-- Error indicator for Tailwind --}}
                <div x-show="hasError" x-transition class="absolute inset-0 bg-red-50/90 flex items-center justify-center rounded-md">
                    <div class="flex flex-col items-center p-6 text-center max-w-md">
                        <svg class="w-12 h-12 text-red-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-red-800 mb-2">Tailwind CSS Gagal Dimuat</h3>
                        <p class="text-sm text-red-600 mb-4">Terjadi kesalahan saat memuat Tailwind CSS. Silakan coba refresh halaman atau gunakan CSS biasa sebagai alternatif.</p>
                        <button @click="renderIframe()" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors text-sm">
                            Coba Lagi
                        </button>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-4 left-4 text-[10px] text-slate-500 bg-slate-900/80 px-2 py-1 rounded backdrop-blur">
                Live Preview &bull; <span x-text="device.charAt(0).toUpperCase() + device.slice(1)"></span> Mode
                <template x-if="library.toLowerCase().includes('tailwind')">
                    <span class="ml-2 text-teal-400">• Tailwind CSS</span>
                </template>
            </div>
        </div>

        {{-- RIGHT: Sidebar Editor --}}
        <div class="w-96 border-l border-slate-800 bg-slate-900 flex flex-col shadow-xl z-10">
            <form
                x-ref="mainForm"
                method="POST"
                action="{{ route('generations.update', $generation) }}"
                class="flex flex-col h-full"
                x-on:submit.prevent="submitForm($event)"
            >
                @csrf
                @method('PUT')

                {{-- Sidebar Tabs --}}
                <div class="px-2 pt-3 pb-0 border-b border-slate-800 bg-slate-900">
                    <div class="flex bg-slate-950 p-1 rounded-lg border border-slate-800/50">
                        <button
                            type="button"
                            @click="tab = 'visual'"
                            class="flex-1 py-1.5 text-xs font-medium rounded-md transition-all text-center"
                            :class="tab === 'visual' ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-400 hover:text-slate-300'"
                        >
                            Visual Editor
                        </button>
                        <button
                            type="button"
                            @click="tab = 'colors'"
                            class="flex-1 py-1.5 text-xs font-medium rounded-md transition-all text-center"
                            :class="tab === 'colors' ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-400 hover:text-slate-300'"
                        >
                            Colors
                        </button>
                        <button
                            type="button"
                            @click="tab = 'advanced'"
                            class="flex-1 py-1.5 text-xs font-medium rounded-md transition-all text-center"
                            :class="tab === 'advanced' ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-400 hover:text-slate-300'"
                        >
                            Code
                        </button>
                    </div>

                    {{-- Status/Feedback Message --}}
                    <div class="h-6 flex items-center justify-center">
                        @if (session('status'))
                            <span class="text-[10px] text-emerald-400 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                {{ session('status') }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Scrollable Content --}}
                <div class="flex-1 overflow-y-auto custom-scrollbar p-4 space-y-5">

                    {{-- VISUAL TAB --}}
                    <div x-show="tab === 'visual'" x-cloak class="space-y-4">
                        <template x-if="schema.length === 0">
                            <div class="text-center py-8 px-4 border border-dashed border-slate-800 rounded-xl bg-slate-950/50">
                                <svg class="w-8 h-8 text-slate-600 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                                <p class="text-xs text-slate-400">Schema editor tidak terdeteksi.</p>
                                <p class="text-[10px] text-slate-500 mt-1">Gunakan tab <b>Code</b> untuk mengedit manual.</p>
                            </div>
                        </template>

                        <template x-for="field in schema" :key="field.id">
                            <div class="group relative">
                                <div class="flex justify-between items-baseline mb-1.5">
                                    <label class="text-[11px] font-bold text-slate-300 tracking-wide" x-text="field.label"></label>
                                    <span class="text-[9px] font-mono text-slate-600 truncate max-w-[100px]" x-text="field.selector"></span>
                                </div>

                                {{-- TEXT --}}
                                <template x-if="field.type === 'text'">
                                    <input
                                        type="text"
                                        class="w-full text-xs bg-slate-950 text-slate-200 border border-slate-700 rounded-lg px-3 py-2 focus:border-orange-500 focus:ring-1 focus:ring-orange-500/50 transition-all placeholder-slate-700"
                                        x-model="fields[field.id]"
                                        x-on:input.debounce.400ms="updateFromField(field)"
                                        :placeholder="initialValues[field.id] || ''"
                                    />
                                </template>

                                {{-- TEXTAREA --}}
                                <template x-if="field.type === 'textarea'">
                                    <textarea
                                        class="w-full text-xs bg-slate-950 text-slate-200 border border-slate-700 rounded-lg px-3 py-2 focus:border-orange-500 focus:ring-1 focus:ring-orange-500/50 transition-all placeholder-slate-700 custom-scrollbar"
                                        rows="4"
                                        x-model="fields[field.id]"
                                        x-on:input.debounce.400ms="updateFromField(field)"
                                        :placeholder="initialValues[field.id] || ''"
                                    ></textarea>
                                </template>

                                {{-- IMAGE --}}
                                <template x-if="field.type === 'image'">
                                    <div class="space-y-2">
                                        <div class="relative">
                                            <input
                                                type="text"
                                                class="w-full text-xs bg-slate-950 text-slate-200 border border-slate-700 rounded-lg pl-3 pr-8 py-2 focus:border-orange-500 focus:ring-1 focus:ring-orange-500/50 transition-all truncate"
                                                x-model="fields[field.id]"
                                                x-on:input.debounce.400ms="updateFromField(field)"
                                                :placeholder="initialValues[field.id] || 'https://...'"
                                            />
                                            <div class="absolute right-2 top-2 text-slate-600">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            </div>
                                        </div>
                                        {{-- Image Preview Thumbnail --}}
                                        <div x-show="fields[field.id]" class="w-full h-24 rounded-lg border border-slate-800 bg-slate-950 overflow-hidden flex items-center justify-center">
                                            <img :src="fields[field.id]" class="max-w-full max-h-full object-contain" onerror="this.style.display='none'">
                                        </div>
                                    </div>
                                </template>

                                {{-- COLOR --}}
                                <template x-if="field.type === 'color'">
                                    <div class="flex items-center gap-2 bg-slate-950 border border-slate-700 rounded-lg p-1.5">
                                        <input
                                            type="color"
                                            class="w-8 h-8 rounded cursor-pointer border-0 p-0 bg-transparent"
                                            x-model="fields[field.id]"
                                            x-on:input.debounce.100ms="updateFromField(field)"
                                        />
                                        <input
                                            type="text"
                                            class="flex-1 text-xs bg-transparent text-slate-200 border-none focus:ring-0 p-0 font-mono uppercase"
                                            x-model="fields[field.id]"
                                            x-on:input.debounce.400ms="updateFromField(field)"
                                            maxlength="7"
                                        />
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>

                    {{-- COLORS TAB --}}
                    <div x-show="tab === 'colors'" x-cloak class="space-y-4">
                        <div class="bg-slate-800/50 rounded-lg p-4 border border-slate-700/50">
                            <h3 class="text-sm font-bold text-white mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                </svg>
                                Color Variables
                            </h3>

                            <div class="space-y-3">
                                <template x-for="colorVar in colorVariables" :key="colorVar.name">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded border border-slate-600" :style="`background-color: ${colorVar.value}`"></div>
                                            <div>
                                                <div class="text-xs font-mono text-slate-300" x-text="colorVar.name"></div>
                                                <div class="text-[10px] text-slate-500" x-text="colorVar.description"></div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <input
                                                type="color"
                                                class="w-7 h-7 rounded cursor-pointer border-0 p-0 bg-transparent"
                                                x-model="colorVar.value"
                                                x-on:input.debounce.100ms="updateColorVariable(colorVar)"
                                            />
                                            <input
                                                type="text"
                                                class="w-20 text-xs bg-slate-950 text-slate-200 border border-slate-700 rounded px-2 py-1 focus:border-orange-500 focus:ring-1 focus:ring-orange-500/50 transition-all font-mono uppercase"
                                                x-model="colorVar.value"
                                                x-on:input.debounce.300ms="updateColorVariable(colorVar)"
                                                maxlength="7"
                                            />
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-700/50 flex justify-between">
                                <button
                                    type="button"
                                    @click="resetColors()"
                                    class="text-xs text-slate-400 hover:text-white transition-colors"
                                >
                                    Reset to Default
                                </button>
                                <button
                                    type="button"
                                    @click="exportColorScheme()"
                                    class="text-xs text-orange-400 hover:text-orange-300 transition-colors"
                                >
                                    Export Scheme
                                </button>
                            </div>
                        </div>

                        <div class="bg-slate-800/50 rounded-lg p-4 border border-slate-700/50">
                            <h3 class="text-sm font-bold text-white mb-2">Generated CSS Variables</h3>
                            <div class="bg-slate-950 rounded-lg p-3 overflow-x-auto">
                                <pre class="text-[10px] text-green-400 font-mono whitespace-pre"><code x-text="generateCSSVariables()"></code></pre>
                            </div>
                            <p class="text-[10px] text-slate-500 mt-2">These variables will be added to your CSS automatically.</p>
                        </div>

                        <div x-show="library.toLowerCase().includes('tailwind')" class="bg-teal-900/20 border border-teal-900/50 p-3 rounded-md">
                            <p class="text-[10px] text-teal-300">
                                <span class="font-bold">Tailwind Tip:</span> Color variables are automatically converted to Tailwind utilities. You can use them in your HTML with classes like <code class="bg-teal-800/30 px-1 rounded">bg-primary</code> or <code class="bg-teal-800/30 px-1 rounded">text-primary</code>.
                            </p>
                        </div>
                    </div>

                    {{-- ADVANCED TAB --}}
                    <div x-show="tab === 'advanced'" x-cloak class="space-y-6">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-300">HTML Body</label>
                                <span class="text-[10px] text-slate-500 font-mono">&lt;body&gt; content</span>
                            </div>
                            <textarea
                                x-model="html"
                                x-on:input.debounce.500ms="renderIframe()"
                                name="html_full"
                                class="w-full h-64 text-[11px] font-mono leading-relaxed bg-slate-950 text-blue-200 border border-slate-700 rounded-lg p-3 focus:outline-none focus:border-orange-500 custom-scrollbar whitespace-pre"
                                spellcheck="false"
                            ></textarea>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-300">Custom CSS</label>
                                <span class="text-[10px] text-slate-500 font-mono">&lt;style&gt;</span>
                            </div>
                            <div class="relative">
                                <textarea
                                    x-model="css"
                                    x-on:input.debounce.500ms="renderIframe()"
                                    name="css_raw"
                                    class="w-full h-48 text-[11px] font-mono leading-relaxed bg-slate-950 text-emerald-200 border border-slate-700 rounded-lg p-3 focus:outline-none focus:border-orange-500 custom-scrollbar whitespace-pre"
                                    spellcheck="false"
                                ></textarea>
                                <div x-show="library.toLowerCase().includes('tailwind')" class="absolute top-2 right-2">
                                    <span class="text-[9px] bg-teal-900/30 text-teal-400 px-2 py-1 rounded-full">Tailwind CSS</span>
                                </div>
                            </div>
                            <div x-show="library.toLowerCase().includes('tailwind')" class="bg-teal-900/20 border border-teal-900/50 p-3 rounded-md">
                                <p class="text-[10px] text-teal-300">
                                    <span class="font-bold">Tips:</span> You can use Tailwind classes and @apply directives in your CSS.
                                </p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-300">Custom JS</label>
                                <span class="text-[10px] text-slate-500 font-mono">&lt;script&gt;</span>
                            </div>
                            <textarea
                                x-model="js"
                                x-on:input.debounce.500ms="renderIframe()"
                                name="js_raw"
                                class="w-full h-48 text-[11px] font-mono leading-relaxed bg-slate-950 text-yellow-200 border border-slate-700 rounded-lg p-3 focus:outline-none focus:border-orange-500 custom-scrollbar whitespace-pre"
                                spellcheck="false"
                            ></textarea>
                            <div class="bg-blue-900/20 border border-blue-900/50 p-3 rounded-md">
                                <p class="text-[10px] text-blue-300">
                                    <span class="font-bold">Tips:</span> JS dieksekusi setelah DOM load. Tidak perlu tag <code>&lt;script&gt;</code>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Custom Scrollbar for dark theme */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #0f172a; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #475569; }

    [x-cloak] { display: none !important; }
</style>
@endsection

@push('scripts')
<script>
function htmlEditor(initial) {
    // PENTING: String ini memecah tag script agar browser tidak menganggapnya
    // sebagai penutup script editor utama.
    const SCRIPT_CLOSE = '<' + '/script>';

    return {
        tab: 'visual',
        device: 'desktop', // desktop, tablet, mobile
        html: initial.html || '',
        css: initial.css || '',
        js: initial.js || '',
        library: initial.library || '',
        schema: initial.schema || [],
        headCssUrls: initial.headCssUrls || [],
        headJsUrls: initial.headJsUrls || [],
        bodyJsUrls: initial.bodyJsUrls || [],
        fields: {},
        initialValues: {},
        isProcessing: false,
        hasError: false,
        renderTimeout: null,
        errorTimeout: null,

        // Variabel warna default
        colorVariables: [
            { name: '--primary-color', value: '#f97316', description: 'Primary accent color' },
            { name: '--secondary-color', value: '#eaeaea', description: 'Secondary color' },
            { name: '--text-dark', value: '#333333', description: 'Dark text color' },
            { name: '--text-muted', value: '#64748b', description: 'Muted text color' },
            { name: '--light-bg', value: '#f8f9fa', description: 'Light background color' }
        ],
        // Cadangan untuk reset
        defaultColorVariables: [
            { name: '--primary-color', value: '#f97316', description: 'Primary accent color' },
            { name: '--secondary-color', value: '#eaeaea', description: 'Secondary color' },
            { name: '--text-dark', value: '#333333', description: 'Dark text color' },
            { name: '--text-muted', value: '#64748b', description: 'Muted text color' },
            { name: '--light-bg', value: '#f8f9fa', description: 'Light background color' }
        ],

        init() {
            this.readInitialValues();
            this.extractExistingColorVariables();
            // Delay render sedikit agar DOM iframe siap
            setTimeout(() => this.renderIframe(), 100);
        },

        setDevice(mode) {
            this.device = mode;
        },


        safeScriptContent(str) {
            if (!str) return '';
            return str.replace(/<\/script>/gi, SCRIPT_CLOSE);
        },

        // --- LOGIKA UTAMA RENDER IFRAME (DIPERBAIKI) ---

        buildHeadAssets() {
            let parts = [];


            this.headCssUrls.forEach(url => {
                parts.push(`<link rel="stylesheet" href="${url}">`);
            });

            // 2. Logika Library (Tailwind)
            const lib = (this.library || '').toLowerCase();
            const isTailwind = lib.includes('tailwind');

            if (isTailwind) {
                // Cek apakah user sudah manual input CDN tailwind agar tidak double
                const hasTailwindManual = this.headJsUrls.some(url => url.includes('tailwindcss'));

                if (!hasTailwindManual) {
                    // Gunakan CDN v3.4.17 agar support konfigurasi via JS Object di bawah
                    parts.push(`<script src="https://cdn.tailwindcss.com/3.4.17">${SCRIPT_CLOSE}`);

                    // Inject Tailwind Config (Mapping Variable Warna)
                    const customColors = this.colorVariables.map(cv => {
                        // Mapping nama variabel CSS ke nama class Tailwind
                        // Contoh: --primary-color diganti jadi class 'primary' (bg-primary, text-primary)
                        if (cv.name === '--primary-color') return `'primary': '${cv.value}'`;
                        if (cv.name === '--secondary-color') return `'secondary': '${cv.value}'`;
                        // Tambahkan mapping lain jika perlu
                        return null;
                    }).filter(Boolean).join(', ');

                    if (customColors) {
                        parts.push(`
                        <script>
                            tailwind.config = {
                                darkMode: "class",
                                theme: {
                                    extend: {
                                        colors: { ${customColors} }
                                    }
                                }
                            };
                        ${SCRIPT_CLOSE}`);
                    }
                }
            }

            // 3. External JS Scripts (Head)
            this.headJsUrls.forEach(url => {
                parts.push(`<script src="${url}">${SCRIPT_CLOSE}`);
            });

            // 4. Custom CSS User
            // Langsung inject ke tag <style>, jauh lebih stabil daripada fungsi JS injection
            if (this.css && this.css.trim().length > 0) {
                parts.push(`<style>${this.css}</style>`);
            }

            // 5. Reset dasar iframe agar preview rapi
            parts.push('<style>body{margin:0; overflow-x:hidden;} img{max-width:100%;}</style>');

            return parts.join('\n');
        },

        buildBodyScripts() {
            let parts = [];

            // External JS Scripts (Body)
            this.bodyJsUrls.forEach(url => {
                parts.push(`<script src="${url}">${SCRIPT_CLOSE}`);
            });

            // Custom JS User
            if (this.js && this.js.trim().length > 0) {
                // Bungkus dengan try-catch agar error user tidak memutihkan layar
                parts.push(`
                <script>
                    try {
                        ${this.safeScriptContent(this.js)}
                    } catch (e) {
                        console.error('Error in Custom JS:', e);
                    }
                ${SCRIPT_CLOSE}`);
            }

            return parts.join('\n');
        },

        buildFullHtml() {

            return [
                '<!DOCTYPE html>',
                '<html lang="id">',
                '<head>',
                '    <meta charset="utf-8">',
                '    <meta name="viewport" content="width=device-width, initial-scale=1">',
                this.buildHeadAssets(),
                '</head>',
                '<body>',
                this.html, // Konten HTML dari editor
                this.buildBodyScripts(),
                '</body>',
                '</html>'
            ].join('\n');
        },

        renderIframe() {
            // Bersihkan timeout sebelumnya
            if (this.renderTimeout) clearTimeout(this.renderTimeout);
            if (this.errorTimeout) clearTimeout(this.errorTimeout);

            this.hasError = false;

            // Indikator loading untuk Tailwind
            if (this.library.toLowerCase().includes('tailwind')) {
                this.isProcessing = true;
            }

            // Debounce render agar tidak berat
            this.renderTimeout = setTimeout(() => {
                const iframe = document.getElementById('previewFrame');
                if (!iframe) return;

                // Gunakan Blob URL (Metode paling aman dan performant untuk preview besar)
                const content = this.buildFullHtml();
                const blob = new Blob([content], { type: 'text/html' });
                const url = URL.createObjectURL(blob);

                iframe.onload = () => {
                    URL.revokeObjectURL(url); // Bersihkan memori

                    // Cek apakah Tailwind berhasil load (khusus jika mode tailwind aktif)
                    if (this.library.toLowerCase().includes('tailwind')) {
                        this.errorTimeout = setTimeout(() => {
                            // Cek variabel global tailwind di dalam iframe
                            const win = iframe.contentWindow;
                            if (win && (win.tailwind || win.getComputedStyle(win.document.body).getPropertyValue('--tw-empty'))) {
                                this.isProcessing = false;
                            } else {
                                // Fallback jika deteksi gagal tapi tampilan mungkin oke
                                this.isProcessing = false;
                            }
                        }, 800);
                    } else {
                        this.isProcessing = false;
                    }
                };

                iframe.src = url;
            }, 300);
        },

        // --- LOGIKA SCHEMA & FORM ---

        readInitialValues() {
            if (!this.schema.length || !this.html) return;
            try {
                const parser = new DOMParser();
                const doc = parser.parseFromString(this.html, 'text/html');

                this.schema.forEach((field) => {
                    const el = doc.querySelector(field.selector);
                    if (!el) return;

                    let value = '';
                    switch (field.attribute) {
                        case 'text': value = el.textContent || ''; break;
                        case 'html': value = el.innerHTML || ''; break;
                        case 'src': value = el.getAttribute('src') || ''; break;
                        case 'href': value = el.getAttribute('href') || ''; break;
                        case 'style.backgroundColor': value = el.style.backgroundColor || ''; break;
                        default: value = '';
                    }

                    if(field.type === 'color' && value.startsWith('rgb')) {
                        value = this.rgbToHex(value);
                    }

                    this.initialValues[field.id] = value;
                    if (this.fields[field.id] === undefined) {
                        this.fields[field.id] = value;
                    }
                });
            } catch (e) {
                console.error("Error parsing schema", e);
            }
        },

        applyFieldToHtml(html, field, value) {
            try {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const el = doc.querySelector(field.selector);

                if (!el) return html; // Jika elemen hilang, kembalikan HTML asli

                switch (field.attribute) {
                    case 'text': el.textContent = value; break;
                    case 'html': el.innerHTML = value; break;
                    case 'src': el.setAttribute('src', value); break;
                    case 'href': el.setAttribute('href', value); break;
                    case 'style.backgroundColor': el.style.backgroundColor = value; break;
                }

                // Ambil body.innerHTML agar tag <html> dan <head> tidak terduplikasi
                return doc.body.innerHTML;
            } catch(e) {
                return html;
            }
        },

        updateFromField(field) {
            const val = this.fields[field.id] ?? '';
            this.html = this.applyFieldToHtml(this.html, field, val);
            this.renderIframe();
        },

        rgbToHex(rgb) {
            const result = rgb.match(/\d+/g);
            if(!result) return rgb;
            return "#" + ((1 << 24) + (parseInt(result[0]) << 16) + (parseInt(result[1]) << 8) + parseInt(result[2])).toString(16).slice(1);
        },

        extractExistingColorVariables() {
            if (!this.css) return;
            const cssVarRegex = /--([a-zA-Z0-9-_]+):\s*([^;]+);/g;
            let match;
            while ((match = cssVarRegex.exec(this.css)) !== null) {
                const varName = `--${match[1]}`;
                const varValue = match[2].trim();
                const colorVar = this.colorVariables.find(cv => cv.name === varName);
                if (colorVar) colorVar.value = varValue;
            }
        },

        updateColorVariable(colorVar) {
            const index = this.colorVariables.findIndex(cv => cv.name === colorVar.name);
            if (index !== -1) this.colorVariables[index].value = colorVar.value;
            this.updateCSSWithColorVariables();
            this.renderIframe();
        },

        updateCSSWithColorVariables() {
            const cssVars = this.generateCSSVariables();
            const rootRegex = /:root\s*\{([^}]*)\}/g;
            if (rootRegex.test(this.css)) {
                this.css = this.css.replace(rootRegex, `:root {${cssVars}}`);
            } else {
                this.css = `:root {${cssVars}}\n\n${this.css}`;
            }
        },

        generateCSSVariables() {
            return this.colorVariables.map(cv => `  ${cv.name}: ${cv.value};`).join('\n');
        },

        resetColors() {
            this.colorVariables = JSON.parse(JSON.stringify(this.defaultColorVariables));
            this.updateCSSWithColorVariables();
            this.renderIframe();
        },

        exportColorScheme() {
            const scheme = {};
            this.colorVariables.forEach(cv => scheme[cv.name] = cv.value);
            const blob = new Blob([JSON.stringify(scheme, null, 2)], {type: 'application/json'});
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'color-scheme.json';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        },

        submitForm(event) {
            event.target.submit();
        },
    }
}
</script>
@endpush
