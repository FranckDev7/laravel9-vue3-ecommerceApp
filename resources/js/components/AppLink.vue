<template>
    <!-- Le composant <component> en Vue sert à rendre dynamiquement un autre composant
    ou une balise HTML en fonction d’une variable. -->
    <component
        :is="tag"
        :href="href"
        :to="to"
        class="w-full transition flex justify-center items-center gap-2 rounded-lg cursor-pointer"
        :class="[sizeClass, colorClass, iconPositionClass]"
        @click="handleClick"
    >
        <!-- Icône LEFT -->
        <span
            v-if="icon && iconPosition === 'left'"
            :class="['material-symbols-outlined', iconSizeClass]"
        >
            {{ icon }}
        </span>

        <!-- Texte ou slot -->
        <span v-if="text">{{ text }}</span>
        <slot v-else />

        <!-- Icône RIGHT -->
        <span
            v-if="icon && iconPosition === 'right'"
            :class="['material-symbols-outlined', iconSizeClass]"
        >
            {{ icon }}
        </span>
    </component>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    /* Navigation */
    to: { type: [String, Object], default: null },   // router-link
    href: { type: String, default: null },           // lien classique

    /* Style */
    color: { type: String, default: 'primary' },
    text: { type: String, default: null },
    icon: { type: String, default: null },
    size: { type: String, default: 'md' },           // sm, md, lg
    iconPosition: { type: String, default: 'left' }, // left, right
    iconSize: { type: String, default: 'md' },       // sm, md, lg

    /* Events */
    onClick: { type: Function, default: null }
})

const emit = defineEmits(['click'])

/* Tag dynamique : router-link ou <a> */
const tag = computed(() => {
    if (props.to) return 'router-link'
    return 'a'
})

/* Click */
const handleClick = (event) => {
    if (props.onClick) props.onClick(event)
    emit('click', event)
}

/* Couleurs */
const colorClass = computed(() => {
    switch (props.color) {
        case 'dark': return 'bg-gray-900 text-white hover:bg-gray-700'
        case 'danger': return 'bg-red-600 text-white hover:bg-red-500'
        case 'success': return 'bg-green-600 text-white hover:bg-green-500'
        case 'warning': return 'bg-yellow-500 text-white hover:bg-yellow-400'
        case 'info': return 'bg-cyan-600 text-white hover:bg-cyan-500'
        case 'primary':
        default: return 'bg-blue-600 text-white hover:bg-blue-500'
    }
})

/* Taille */
const sizeClass = computed(() => {
    switch (props.size) {
        case 'sm': return 'text-xs px-1 py-0.5'
        case 'lg': return 'text-lg px-3 py-2'
        case 'md':
        default: return 'text-sm px-2 py-1'
    }
})

/* Position icône */
const iconPositionClass = computed(() => {
    return props.iconPosition === 'right'
        ? 'flex-row-reverse'
        : 'flex-row'
})

/* Taille icône */
const iconSizeClass = computed(() => {
    switch (props.iconSize) {
        case 'sm': return 'text-base'
        case 'lg': return 'text-2xl'
        case 'md':
        default: return 'text-xl'
    }
})
</script>
