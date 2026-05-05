<script setup lang="ts">
import StarterKit from '@tiptap/starter-kit';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import { cn } from '@/lib/utils';

const editor = useEditor({
    extensions: [StarterKit],
    injectCSS: false,
    editorProps: {
        attributes: {
            class: cn([
                'm-5 prose prose-sm focus:outline-none sm:prose-base lg:prose-lg xl:prose-2xl dark:prose-invert',
                'rounded-md border border-input bg-transparent p-6 text-base shadow-xs transition-[color,box-shadow] outline-none selection:bg-primary placeholder:text-muted-foreground disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm dark:bg-input/30',
                'focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50',
                'aria-invalid:border-destructive aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40',
            ]),
        },
    },
    content: `
        <h2>
      Hi there,
    </h2>
    <p>
      this is a basic <em>basic</em> example of <strong>Tiptap</strong>. Sure, there are all kind of basic text styles you’d probably expect from a text editor. But wait until you see the lists:
    </p>
    <ul>
      <li>
        That’s a bullet list with one …
      </li>
      <li>
        … or two list items.
      </li>
    </ul>
    <p>
      Isn’t that great? And all of that is editable. But wait, there’s more. Let’s try a code block:
    </p>
<pre><code class="language-css">body {
  display: none;
}</code></pre>
    <p>
      I know, I know, this is impressive. It’s only the tip of the iceberg though. Give it a try and click a little bit around. Don’t forget to check the other examples too.
    </p>
    <blockquote>
      Wow, that’s amazing. Good work, boy! 👏
      <br />
      — Mom
    </blockquote>
    `,
});
</script>
<template>
    <editor-content :editor="editor" />
</template>
