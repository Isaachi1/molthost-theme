<div x-data>
    <template x-for="(notification, index) in $store.notifications.notifications" :key="notification.id">
        <div x-show="notification.show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2" @click="$store.notifications.removeNotification(notification.id)"
            :class="notification.type === 'success' ? 'bg-primary text-inverted' : 'bg-red-600 text-white'"
            class="fixed px-5 py-3 rounded-xl shadow-lg mb-4 z-50 cursor-pointer font-semibold text-sm"
            :style="'top: ' + (20 + index * 60) + 'px;left: 50%; transform: translateX(-50%);'">
            <p x-text="notification.message"></p>
        </div>
    </template>
</div>
