<script setup lang="ts">
import StarterKit from '@tiptap/starter-kit';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import { cn } from '@/lib/utils'; // Assuming this resolves your tailwind-merge/clsx

const emit = defineEmits(['update:content']);

const editor = useEditor({
    extensions: [StarterKit],
    injectCSS: false, // Excellent: removes default TipTap bloat
    editorProps: {
        attributes: {
            class: cn([
                // Core Typography & Layout
                'prose min-h-[200px] w-full max-w-none dark:prose-invert',

                // Base Shadcn Form Input Styles
                'rounded-md border border-input bg-transparent p-4 text-base shadow-xs transition-[color,box-shadow] md:text-sm',
                'selection:bg-primary placeholder:text-muted-foreground dark:bg-input/30',

                // States (Focus, Disabled, Invalid)
                'outline-none focus:outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50',
                'disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50',
                'aria-invalid:border-destructive aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40',
            ]),
        },
    },
    onCreate: ({ editor }) => {
        emit('update:content', editor.getJSON());
    },
    onUpdate: (props) => {
        emit('update:content', props.editor.getJSON());
    },
    content: `
    <h2>Hi there,</h2>
    <p>this is a basic <em>basic</em> example of <strong>Tiptap</strong>. Sure, there are all kind of basic text styles you’d probably expect from a text editor. But wait until you see the lists:</p>
    <ul>
      <li>That’s a bullet list with one …</li>
      <li>… or two list items.</li>
    </ul>
    `,
});
</script>

<template>
    <editor-content :editor="editor" />
</template>
