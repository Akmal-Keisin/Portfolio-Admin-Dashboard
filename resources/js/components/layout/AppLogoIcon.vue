<script setup lang="ts">
import { UserCog } from 'lucide-vue-next';
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <UserCog :class="className" v-bind="$attrs" />
</template>
