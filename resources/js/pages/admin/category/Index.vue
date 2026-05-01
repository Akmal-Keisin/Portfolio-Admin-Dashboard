<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { SearchIcon } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from '@/components/ui/input-group';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCaption from '@/components/ui/table/TableCaption.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableFooter from '@/components/ui/table/TableFooter.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import category from '@/routes/category';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Category',
                href: category.index(),
            },
        ],
    },
});

const invoices = [
    {
        invoice: 'INV001',
        paymentStatus: 'Paid',
        totalAmount: '$250.00',
        paymentMethod: 'Credit Card',
    },
    {
        invoice: 'INV002',
        paymentStatus: 'Pending',
        totalAmount: '$150.00',
        paymentMethod: 'PayPal',
    },
    {
        invoice: 'INV003',
        paymentStatus: 'Unpaid',
        totalAmount: '$350.00',
        paymentMethod: 'Bank Transfer',
    },
    {
        invoice: 'INV004',
        paymentStatus: 'Paid',
        totalAmount: '$450.00',
        paymentMethod: 'Credit Card',
    },
    {
        invoice: 'INV005',
        paymentStatus: 'Paid',
        totalAmount: '$550.00',
        paymentMethod: 'PayPal',
    },
    {
        invoice: 'INV006',
        paymentStatus: 'Pending',
        totalAmount: '$200.00',
        paymentMethod: 'Bank Transfer',
    },
    {
        invoice: 'INV007',
        paymentStatus: 'Unpaid',
        totalAmount: '$300.00',
        paymentMethod: 'Credit Card',
    },
];
</script>

<template>
    <Head title="Category" />
    <div class="mb-2 flex items-center justify-between">
        <div>
            <InputGroup>
                <InputGroupInput placeholder="Search..." />
                <InputGroupAddon>
                    <SearchIcon />
                </InputGroupAddon>
            </InputGroup>
        </div>
        <div>
            <Button>Create</Button>
        </div>
    </div>
    <div class="overflow-hidden rounded-sm border">
        <Table>
            <TableCaption>A list of your recent invoices.</TableCaption>
            <TableHeader class="sticky top-0 z-10 bg-muted">
                <TableRow>
                    <TableHead class="w-25"> Invoice </TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead>Method</TableHead>
                    <TableHead class="text-right"> Amount </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody class="**:data-[slot=table-cell]:first:w-8">
                <TableRow v-for="invoice in invoices" :key="invoice.invoice">
                    <TableCell class="font-medium">
                        {{ invoice.invoice }}
                    </TableCell>
                    <TableCell>{{ invoice.paymentStatus }}</TableCell>
                    <TableCell>{{ invoice.paymentMethod }}</TableCell>
                    <TableCell class="text-right">
                        {{ invoice.totalAmount }}
                    </TableCell>
                </TableRow>
            </TableBody>
            <TableFooter>
                <TableRow>
                    <TableCell colspan="3"> Total </TableCell>
                    <TableCell class="text-right"> $2,500.00 </TableCell>
                </TableRow>
            </TableFooter>
        </Table>
    </div>
</template>
