@extends('layouts.app')

@section('content')
    <div x-data="htmlEditor({
        html: @js($generation->html_full ?? ''),
        css: @js($generation->css_raw ?? ''),
        js: @js($generation->js_raw ?? ''),
        headCss: @js($headCss->pluck('url')),
        headJs: @js($headJs->pluck('url')),
        bodyJs: @js($bodyJs->pluck('url')),
    })" x-init="init()" class="grid grid-cols-1 lg:grid-cols-[2fr,1.5fr] gap-6">
        <div class="border border-slate-800 rounded-xl overflow-hidden bg-black/60">
            <div class="px-4 py-2 border-b border-slate-800 text-xs text-slate-400 flex items-center justify-between">
                <span>Live Preview</span>
            </div>
            <iframe id="previewFrame" class="w-full h-[70vh] bg-white"></iframe>
        </div>

        {{-- panel editor field lu di sini --}}

        <form method="POST" action="{{ route('generations.update', $generation) }}" x-ref="form" class="hidden">
            @csrf
            @method('PUT')
            <textarea name="html_full" x-model="html" class="hidden"></textarea>
            <textarea name="css_raw" x-model="css" class="hidden"></textarea>
            <textarea name="js_raw" x-model="js" class="hidden"></textarea>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function htmlEditor(initial) {
            return {
                html: initial.html || '',
                css: initial.css || '',
                js: initial.js || '',
                headCss: initial.headCss || [],
                headJs: initial.headJs || [],
                bodyJs: initial.bodyJs || [],

                init() {
                    this.renderIframe();
                },

                renderIframe() {
                    const iframe = document.getElementById('previewFrame');
                    if (!iframe) return;

                    const doc = iframe.contentDocument || iframe.contentWindow.document;

                    let headLinks = '';

                    this.headCss.forEach(url => {
                        headLinks += `<link rel="stylesheet" href="${url}">`;
                    });

                    this.headJs.forEach(url => {
                                headLinks += `<script src="${url}">
    </script>`;
    });

    const cssBlock = this.css ? `<style>
        $ {
            this.css
        }
    </style>` : '';

    let bodyScripts = '';

    this.bodyJs.forEach(url => {
    bodyScripts += `
    <script src="${url}"></script>`;
    });

    const jsBlock = this.js ? `
    <script>
        $ {
            this.js
        }
    </script>` : '';

    const fullHtml = `
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        ${headLinks}
        ${cssBlock}
    </head>

    <body>
        ${this.html}
        ${bodyScripts}
        ${jsBlock}
    </body>

    </html>
    `.trim();

    doc.open();
    doc.write(fullHtml);
    doc.close();
    },
    }
    }
    </script>
@endpush
