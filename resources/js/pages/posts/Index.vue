<template>
  <AppLayout>
    <template #header>
      <h1 class="text-2xl font-bold">Articles du blog</h1>
    </template>

    <div class="py-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
          
          <Link
            :href="route('posts.create')"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
          >
            Nouvel article
          </Link>
        </div>

       

        <div class="bg-white shadow-md rounded my-6">
          <table class="min-w-max w-full table-auto">
            <thead>
              <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Titre</th>
                <th class="py-3 px-6 text-center">Date de publication</th>
                <th class="py-3 px-6 text-center">Actions</th>
              </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
              <tr v-for="post in posts.data" :key="post.id" class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6 text-left whitespace-nowrap">
                  <div class="font-medium">{{ post.title }}</div>
                </td>
                <td class="py-3 px-6 text-center">
                  {{ formatDate(post.published_at) }}
                </td>
                <td class="py-3 px-6 text-center">
                  <div class="flex item-center justify-center space-x-2">
                    <Link
                      :href="route('posts.show', post.slug)"
                      class="text-blue-500 hover:text-blue-700"
                    >
                      Voir
                    </Link>
                    <Link
                      :href="route('posts.edit', post.slug)"
                      class="text-green-500 hover:text-green-700"
                    >
                      Modifier
                    </Link>
                    <button
                      @click="deletePost(post)"
                      class="text-red-500 hover:text-red-700"
                    >
                      Supprimer
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
//import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

interface Post {
  id: number;
  title: string;
  slug: string;
  published_at: string | null;
}

interface Props {
  posts: {
    data: Post[];
    links: any[];
  };

}

defineProps<Props>();





const deletePost = (post: Post) => {
  if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
    router.delete(route('posts.destroy', post.slug));
  }
};

const formatDate = (date: string | null) => {
  if (!date) return 'Non publié';
  return new Date(date).toLocaleDateString('fr-FR');
};
</script>