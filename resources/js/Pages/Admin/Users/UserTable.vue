<template>
    <loading v-if="loading"></loading>
    <div class="contain-section w-full p-4 mx-auto rounded-lg">
        <div>
            <table
                class="w-full table-auto shadow"
                v-if="
                    !isEmpty &&
                    sessionUser.permissions.some(
                        (permission) => permission.name == 'read_users'
                    )
                "
            >
                <thead>
                    <tr class="text-left border-b border-black">
                        <th>user</th>
                        <th>email</th>
                        <th>title</th>
                        <th class="text-center">works</th>
                        <th class="text-center">blogs</th>
                        <th class="text-center">action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="transition hover:bg-black hover:scale-50 border-b border-gray-500 border-opacity-30"
                        v-for="(user, index) in users"
                        :key="index"
                    >
                        <td>
                            <img
                                :src="user.image_path"
                                class="w-8 h-8 inline rounded-full mr-2"
                            />
                            <span> {{ user.name }} </span>
                        </td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.title }}</td>
                        <td class="text-center">{{ user.works_count }}</td>
                        <td class="text-center">{{ user.blogs_count }}</td>
                        <td class="text-center">
                            <buttons-list>
                                <template #title>
                                    <icon
                                        icon="majesticons:dots-circle-line"
                                        class="h-6 w-6"
                                    />
                                </template>
                                <template #>
                                    <button
                                        class="button-list"
                                        v-if="
                                            sessionUser.permissions.some(
                                                (permission) =>
                                                    permission.name ==
                                                    'create_users'
                                            ) && !user.email_verified_at
                                        "
                                        @click.prevent="verifyUser(user.id)"
                                    >
                                        <div class="flex gap-2 items-center">
                                            <icon
                                                icon="bx:bx-user-check"
                                                class="inline w-4 h-4"
                                            />
                                            <span>verify</span>
                                        </div>
                                    </button>
                                    <router-link
                                        class="button-list"
                                        :to="{
                                            name: 'admin.users.edit',
                                            query: {
                                                id: user.id,
                                            },
                                            params: {
                                                slug: user.slug,
                                            },
                                        }"
                                        v-if="
                                            sessionUser.permissions.some(
                                                (permission) =>
                                                    permission.name ==
                                                    'update_users'
                                            )
                                        "
                                    >
                                        <div class="flex gap-2 items-center">
                                            <icon
                                                icon="akar-icons:edit"
                                                class="inline w-4 h-4"
                                            />
                                            <span>edit</span>
                                        </div>
                                    </router-link>
                                    <button
                                        class="button-list"
                                        v-if="
                                            sessionUser.permissions.some(
                                                (permission) =>
                                                    permission.name ==
                                                    'delete_users'
                                            )
                                        "
                                        @click="askDeleteUser(user.id)"
                                    >
                                        <div class="flex gap-2 items-center">
                                            <icon
                                                icon="bx:bxs-trash"
                                                class="inline w-4 h-4"
                                            />
                                            <span>delete</span>
                                        </div>
                                    </button>
                                </template>
                            </buttons-list>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="col-span-full p-4">
                            <icon
                                icon="akar-icons:chevron-left"
                                class="h-6 w-6 inline mr-5 cursor-pointer"
                                :class="disablePreviousPage"
                                @click="$emit('previuosPage')"
                            />
                            <span class="mr-5">{{ currentPage }}</span>
                            <icon
                                icon="akar-icons:chevron-right"
                                class="h-6 w-6 inline mr-5 cursor-pointer"
                                :class="disableNextPage"
                                @click="$emit('nextPage')"
                            />
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div v-else class="text-center">There is no data to show</div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: ["users", "isEmpty", "currentPage", "firstPage", "lastPage"],
    emits: ["previuosPage", "nextPage", "reloadUsers"],

    data() {
        return {
            intendedIdToDelete: null,
            loading: false,
        };
    }, //end of data

    computed: {
        disablePreviousPage() {
            return { hidden: this.firstPage == this.currentPage };
        },
        disableNextPage() {
            return { hidden: this.lastPage == this.currentPage };
        },

        ...mapGetters({
            answer: "getConfirmAnswer",
            sessionUser: "admin/getUser",
        }),
    }, //end of disableNextPage

    watch: {
        answer(gotAnswer) {
            if (gotAnswer == "yes") {
                this.deleteUser();
            }
        },
    },

    methods: {
        verifyUser(userId) {
            axios.post(`/api/admin/users/${userId}/verify`).then((response) => {
                this.$emit("reloadUsers");
                //flash message
                this.$store.dispatch("flashMessage", {
                    message: "user verified successfully",
                });
            });
        }, //end of verifyUser

        askDeleteUser(blogCategoryId) {
            this.intendedIdToDelete = blogCategoryId;
            this.$store.dispatch("askConfirmMessage", {
                message: "do you really want to delete this user?",
            });
        }, //end if askDeleteUser

        deleteUser() {
            this.loading = true;
            axios
                .delete(`/api/admin/users/${this.intendedIdToDelete}`)
                .then((response) => {
                    this.$emit("reloadUsers");
                    //flash message
                    this.$store.dispatch("flashMessage", {
                        message: response.data,
                    });
                })
                .then(() => {
                    this.loading = false;
                });
        },
    }, //end of methods
};
</script>
