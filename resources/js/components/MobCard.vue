<template>
    <div class="bg-gray-100 border border-blue-300 p-6 shadow rounded-lg hover:bg-blue-100 cursor-pointer"
         @click="goToMob">
        <div class="flex" :class="{'mb-4': socialMob.title}" v-if="socialMob.title || isDraggable">
            <h3 class="flex-1 font-light text-lg text-blue-700 text-left mb-3"
                :class="{'pr-4': isDraggable}"
                v-text="socialMob.title"/>
            <div v-if="isDraggable"
                 @click.stop
                 class="z-10 handle cursor-grab">
                <icon-draggable class="h-6 text-blue-600 hover:text-blue-800"/>
            </div>
        </div>
        <pre
            class="mb-4 inline-block text-left break-words-fixed whitespace-pre-wrap max-h-64 overflow-y-auto overflow-x-hidden font-sans"
            v-text="socialMob.topic"/>
        <div class="flex items-center flex-1 mb-4 text-blue-700">
            <p class="mr-3">Host:</p>
            <p class="mr-6 text-md" v-text="socialMob.owner.name"/>
            <v-avatar :src="socialMob.owner.avatar" :alt="`${socialMob.owner.name}'s Avatar`" size="6"/>
        </div>
        <div class="flex justify-between mb-2 text-blue-700">
            <div class="flex items-center attendees-count">
                <i class="fa fa-user-circle text-lg mr-2" aria-hidden="true"></i>
                <span v-text="socialMob.attendees.length"/>
                <span v-if="socialMob.attendee_limit" class="pl-1 attendee-limit">of {{ socialMob.attendee_limit }}</span>
            </div>
            <div class="flex items-center">
                <i class="fa fa-clock-o text-lg mr-2" aria-hidden="true"></i>
                {{socialMob.startTime}} to {{socialMob.endTime}}
            </div>
        </div>

        <div class="text-blue-700 text-left mb-4 break-all">
            <i class="fa fa-compass text-xl mr-1" aria-hidden="true"></i>
            <location-renderer :locationString="socialMob.location"/>
        </div>

        <button
            class="join-button w-32 bg-blue-500 hover:bg-blue-700 focus:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            @click.stop="joinMob"
            v-show="socialMob.canJoin(user)">
            Join
        </button>
        <button
            class="leave-button w-32 bg-red-500 hover:bg-red-700 focus:bg-red-700  text-white font-bold py-2 px-4 rounded"
            @click.stop="leaveMob"
            v-show="socialMob.canLeave(user)">
            Leave
        </button>
        <div v-show="socialMob.canEditOrDelete(user)">
            <button
                class="update-button w-32 bg-orange-500 hover:bg-orange-700 focus:bg-orange-700 text-white font-bold py-2 px-4 rounded"
                @click.stop="$emit('edit-requested', socialMob)">
                Edit
            </button>
            <button
                class="delete-button w-16 bg-red-500 hover:bg-red-700 focus:bg-red-700 text-white font-bold py-2 px-4 rounded"
                @click.stop="onDeleteClicked">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</template>

<script lang="ts">
    import {Component, Prop, Vue} from 'vue-property-decorator';
    import {SocialMobApi} from '../services/SocialMobApi';
    import {SocialMob} from '../classes/SocialMob';
    import {IUser} from '../types';
    import VAvatar from './VAvatar.vue';
    import IconDraggable from '../svgs/IconDraggable.vue';
    import LocationRenderer from './LocationRenderer.vue';

    @Component({
        components: {VAvatar, IconDraggable, LocationRenderer}
    })
    export default class MobCard extends Vue {
        @Prop({required: true}) socialMob!: SocialMob;
        @Prop({required: false, default: null}) user!: IUser;

        goToMob() {
            window.location.assign(SocialMobApi.showUrl(this.socialMob));
        }

        async joinMob() {
            await this.socialMob.join();
            this.$emit('mob-updated');
        }

        async leaveMob() {
            await this.socialMob.leave();
            this.$emit('mob-updated');
        }

        get isDraggable(): boolean {
            return this.socialMob.canEditOrDelete(this.user);
        }

        async onDeleteClicked() {
            if (confirm('Are you sure you want to delete?')) {
                await this.socialMob.delete();
                this.$emit('delete-requested', this.socialMob);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .handle {
        margin: -0.7rem;
    }

    .cursor-grab {
        cursor: grab;

        &:active {
            cursor: grabbing;
        }
    }
</style>
