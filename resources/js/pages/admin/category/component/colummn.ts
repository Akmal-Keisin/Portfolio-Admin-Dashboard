import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';
import type { Category } from '@/types/model/category';
import DropdownAction from './data-table.dropdown.vue';

export const columns: ColumnDef<Category>[] = [
    {
        accessorKey: 'no',
        header: () => h('div', { class: 'text-right' }, 'No.'),
        cell: ({ row }) =>
            h('div', { class: 'text-right font-medium' }, row.index + 1),
    },
    {
        accessorKey: 'name',
        header: () => h('div', { class: 'text-right' }, 'Name'),
        cell: ({ row }) =>
            h('div', { class: 'text-right font-medium' }, row.getValue('name')),
    },
    {
        accessorKey: 'article_count',
        header: () => h('div', { class: 'text-right' }, 'Article Count'),
        cell: ({ row }) =>
            h(
                'div',
                { class: 'text-right font-medium' },
                row.getValue('article_count'),
            ),
    },
    {
        accessorKey: 'created_at',
        header: () => h('div', { class: 'text-right' }, 'Created At'),
        cell: ({ row }) =>
            h(
                'div',
                { class: 'text-right font-medium' },
                row.getValue('created_at'),
            ),
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const category = row.original;

            return h(
                'div',
                { class: 'relative' },
                h(DropdownAction, {
                    category,
                }),
            );
        },
    },
];
