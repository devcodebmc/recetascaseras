<style>
    .ProseMirror:focus {
      outline: none;
    }
  
    .tiptap ul p,
    .tiptap ol p {
      display: inline;
    }
  
    .tiptap p.is-editor-empty:first-child::before {
      content: attr(data-placeholder);
      float: left;
      height: 0;
      pointer-events: none;
    }
    @media (prefers-color-scheme: dark) {
      .dark\:text-neutral-200 {
        --tw-text-opacity: 1;
        color: rgb(31 41 55 / var(--tw-text-opacity, 1));
      }
    }
</style>
  <!-- Tiptap -->
  <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div id="hs-editor-tiptap-blockquote-alt">
      <div class="sticky top-0 bg-white flex align-middle gap-x-0.5 border-b border-gray-200 p-2">
        <button class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" type="button" data-hs-editor-bold="">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 12a4 4 0 0 0 0-8H6v8"></path>
            <path d="M15 20a4 4 0 0 0 0-8H6v8Z"></path>
          </svg>
        </button>
        <button class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" type="button" data-hs-editor-italic="">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" x2="10" y1="4" y2="4"></line>
            <line x1="14" x2="5" y1="20" y2="20"></line>
            <line x1="15" x2="9" y1="4" y2="20"></line>
          </svg>
        </button>
        <button class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" type="button" data-hs-editor-underline="">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 4v6a6 6 0 0 0 12 0V4"></path>
            <line x1="4" x2="20" y1="20" y2="20"></line>
          </svg>
        </button>
        <button class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" type="button" data-hs-editor-strike="">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 4H9a3 3 0 0 0-2.83 4"></path>
            <path d="M14 12a4 4 0 0 1 0 8H6"></path>
            <line x1="4" x2="20" y1="12" y2="12"></line>
          </svg>
        </button>
        <button class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" type="button" data-hs-editor-link="">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
          </svg>
        </button>
        <button class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" type="button" data-hs-editor-ol="">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="10" x2="21" y1="6" y2="6"></line>
            <line x1="10" x2="21" y1="12" y2="12"></line>
            <line x1="10" x2="21" y1="18" y2="18"></line>
            <path d="M4 6h1v4"></path>
            <path d="M4 10h2"></path>
            <path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"></path>
          </svg>
        </button>
        <button class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" type="button" data-hs-editor-ul="">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="8" x2="21" y1="6" y2="6"></line>
            <line x1="8" x2="21" y1="12" y2="12"></line>
            <line x1="8" x2="21" y1="18" y2="18"></line>
            <line x1="3" x2="3.01" y1="6" y2="6"></line>
            <line x1="3" x2="3.01" y1="12" y2="12"></line>
            <line x1="3" x2="3.01" y1="18" y2="18"></line>
          </svg>
        </button>
        <button class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" type="button" data-hs-editor-blockquote="">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 6H3"></path>
            <path d="M21 12H8"></path>
            <path d="M21 18H8"></path>
            <path d="M3 12v6"></path>
          </svg>
        </button>
        <button class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" type="button" data-hs-editor-code="">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m18 16 4-4-4-4"></path>
            <path d="m6 8-4 4 4 4"></path>
            <path d="m14.5 4-5 16"></path>
          </svg>
        </button>
      </div>

      <div class="h-80 overflow-auto" data-hs-editor-field=""></div>
    </div>
  </div>

  <!-- Campo oculto para almacenar el contenido del editor -->
  <textarea name="description" id="description-input" class="w-full mt-3 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" hidden>
    {{ old('description', isset($recipe) ? $recipe->description : '') }}
  </textarea>

  @error('description')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
  @enderror
  <!-- End Tiptap -->
  <script type="module">
      const oldDescription = @json($oldDescription); // Pasar el valor de old al JavaScript
  </script>
  
  <script type="module">
    import { Editor, Node } from 'https://esm.sh/@tiptap/core';
    import StarterKit from 'https://esm.sh/@tiptap/starter-kit';
    import Placeholder from 'https://esm.sh/@tiptap/extension-placeholder';
    import Paragraph from 'https://esm.sh/@tiptap/extension-paragraph';
    import Bold from 'https://esm.sh/@tiptap/extension-bold';
    import Underline from 'https://esm.sh/@tiptap/extension-underline';
    import Link from 'https://esm.sh/@tiptap/extension-link';
    import BulletList from 'https://esm.sh/@tiptap/extension-bullet-list';
    import OrderedList from 'https://esm.sh/@tiptap/extension-ordered-list';
    import ListItem from 'https://esm.sh/@tiptap/extension-list-item';

    const CustomBlockquote = Node.create({
        name: 'customBlockquote',
        group: 'block',
        content: 'block+',
        defining: true,
        parseHTML() {
            return [{ tag: 'blockquote' }]
        },
        addOptions() {
            return {
                HTMLAttributes: {},
            }
        },
        addNodeView() {
            return ({ node }) => {
                const blockquote = document.createElement('blockquote');

                Object.entries(this.options.HTMLAttributes).forEach(([key, value]) => {
                    blockquote.setAttribute(key, value);
                });

                const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                svg.setAttribute('class', 'absolute top-0 start-0 size-16 text-gray-500 dark:text-neutral-700');
                svg.setAttribute('width', '16');
                svg.setAttribute('height', '16');
                svg.setAttribute('viewBox', '0 0 16 16');
                svg.setAttribute('fill', 'none');
                svg.setAttribute('aria-hidden', 'true');

                const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                path.setAttribute('d', 'M7.39762 10.3C7.39762 11.0733 7.14888 11.7 6.6514 12.18C6.15392 12.6333 5.52552 12.86 4.76621 12.86C3.84979 12.86 3.09047 12.5533 2.48825 11.94C1.91222 11.3266 1.62421 10.4467 1.62421 9.29999C1.62421 8.07332 1.96459 6.87332 2.64535 5.69999C3.35231 4.49999 4.33418 3.55332 5.59098 2.85999L6.4943 4.25999C5.81354 4.73999 5.26369 5.27332 4.84476 5.85999C4.45201 6.44666 4.19017 7.12666 4.05926 7.89999C4.29491 7.79332 4.56983 7.73999 4.88403 7.73999C5.61716 7.73999 6.21938 7.97999 6.69067 8.45999C7.16197 8.93999 7.39762 9.55333 7.39762 10.3ZM14.6242 10.3C14.6242 11.0733 14.3755 11.7 13.878 12.18C13.3805 12.6333 12.7521 12.86 11.9928 12.86C11.0764 12.86 10.3171 12.5533 9.71484 11.94C9.13881 11.3266 8.85079 10.4467 8.85079 9.29999C8.85079 8.07332 9.19117 6.87332 9.87194 5.69999C10.5789 4.49999 11.5608 3.55332 12.8176 2.85999L13.7209 4.25999C13.0401 4.73999 12.4903 5.27332 12.0713 5.85999C11.6786 6.44666 11.4168 7.12666 11.2858 7.89999C11.5215 7.79332 11.7964 7.73999 12.1106 7.73999C12.8437 7.73999 13.446 7.97999 13.9173 8.45999C14.3886 8.93999 14.6242 9.55333 14.6242 10.3Z');
                path.setAttribute('fill', 'currentColor');
                svg.appendChild(path);

                blockquote.appendChild(svg);

                const contentWrapper = document.createElement('div');
                contentWrapper.classList.add('relative', 'z-10', 'italic');
                blockquote.appendChild(contentWrapper);

                return {
                    dom: blockquote,
                    contentDOM: contentWrapper
                }
            }
        }
    });

    // Obtener el valor de old desde el campo oculto
    const oldDescription = document.getElementById('description-input')?.value || '';

    const editor = new Editor({
        element: document.querySelector('#hs-editor-tiptap-blockquote-alt [data-hs-editor-field]'),
        editorProps: {
            attributes: {
                class: 'relative min-h-40 p-3'
            }
        },
        extensions: [
            StarterKit.configure({
                blockquote: false,
                history: false
            }),
            Placeholder.configure({
                placeholder: 'Describe la receta...',
                emptyNodeClass: 'before:text-gray-400'
            }),
            Paragraph.configure({
                HTMLAttributes: {
                    class: 'text-md text-gray-800 dark:text-neutral-200',
                    name: 'descriptionEditor',
                    id: 'descriptionEditor'
                }
            }),
            Bold.configure({
                HTMLAttributes: {
                    class: 'font-bold'
                }
            }),
            Underline,
            Link.configure({
                HTMLAttributes: {
                    class: 'inline-flex items-center gap-x-1 text-blue-600 decoration-2 hover:underline focus:outline-hidden focus:underline font-medium dark:text-white'
                }
            }),
            BulletList.configure({
                HTMLAttributes: {
                    class: 'list-disc list-inside text-gray-800 dark:text-white'
                }
            }),
            OrderedList.configure({
                HTMLAttributes: {
                    class: 'list-decimal list-inside text-gray-800 dark:text-white'
                }
            }),
            ListItem.configure({
                HTMLAttributes: {
                    class: 'marker:text-sm'
                }
            }),
            CustomBlockquote.configure({
                HTMLAttributes: {
                    class: 'relative sm:[&>div>p]:text-xl pt-6 pb-4 pe-4 ps-8'
                }
            })
        ],
        content: oldDescription, // Inicializar el editor con el valor de old
        onUpdate: ({ editor }) => {
            // Obtener el contenido HTML del editor
            const content = editor.getHTML();
            // Actualizar el valor del campo oculto
            document.getElementById('description-input').value = content;
        }
    });

    const actions = [
        {
            id: '#hs-editor-tiptap-blockquote-alt [data-hs-editor-bold]',
            fn: () => editor.chain().focus().toggleBold().run()
        },
        {
            id: '#hs-editor-tiptap-blockquote-alt [data-hs-editor-italic]',
            fn: () => editor.chain().focus().toggleItalic().run()
        },
        {
            id: '#hs-editor-tiptap-blockquote-alt [data-hs-editor-underline]',
            fn: () => editor.chain().focus().toggleUnderline().run()
        },
        {
            id: '#hs-editor-tiptap-blockquote-alt [data-hs-editor-strike]',
            fn: () => editor.chain().focus().toggleStrike().run()
        },
        {
            id: '#hs-editor-tiptap-blockquote-alt [data-hs-editor-link]',
            fn: () => {
                const url = window.prompt('URL');
                editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
            }
        },
        {
            id: '#hs-editor-tiptap-blockquote-alt [data-hs-editor-ol]',
            fn: () => editor.chain().focus().toggleOrderedList().run()
        },
        {
            id: '#hs-editor-tiptap-blockquote-alt [data-hs-editor-ul]',
            fn: () => editor.chain().focus().toggleBulletList().run()
        },
        {
            id: '#hs-editor-tiptap-blockquote-alt [data-hs-editor-blockquote]',
            fn: () => editor.chain().focus().toggleWrap('customBlockquote').run()
        },
        {
            id: '#hs-editor-tiptap-blockquote-alt [data-hs-editor-code]',
            fn: () => editor.chain().focus().toggleCode().run()
        }
    ];

    actions.forEach(({ id, fn }) => {
        const action = document.querySelector(id);

        if (action === null) return;

        action.addEventListener('click', fn);
    });
</script>