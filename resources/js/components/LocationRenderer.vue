<template>
    <span>
        <template v-for="part in parts">
            <template v-if="part.isURL">{{part.gap}}<a :href="part.content" class="underline">{{part.content}}</a></template>
            <template v-else>{{part.gap + part.content}}</template>
        </template>
    </span>
</template>

<script lang='ts'>
    import {Component, Prop, Vue} from "vue-property-decorator";

    @Component
    export default class LocationRenderer extends Vue {
        @Prop({required: true}) locationString!: string;

        get parts() {
            const partRegex = /\b[^\s]+\b/g;
            const parts = this.locationString.match(partRegex) ?? [];
            const gaps = this.locationString.split(partRegex);
            return parts.map((part, i) => ({
                content: part,
                isURL: this.isURL(part),
                gap: gaps[i]
            }));
        }

        isURL(candidate: string): boolean {
            try {
                new URL(candidate);
                return true;
            } catch {
                return false;
            }
        }
    }
</script>

<style scoped>
</style>
