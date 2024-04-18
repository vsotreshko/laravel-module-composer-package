<template>
  <PageHeader :title="$t('craftable-pro', 'Orders')">
    <Button
      :leftIcon="PlusIcon"
      :as="Link"
      :href="route('craftable-pro.orders.create')"
      v-can="'craftable-pro.order.create'"
    >
      {{ $t("craftable-pro", "New Order") }}
    </Button>
    
  </PageHeader>

  <PageContent>
    <Listing
      :baseUrl="route('craftable-pro.orders.index')"
      :data="orders"
      dataKey="orders"
    >
      <template #bulkActions="{ bulkAction }">
        <Modal type="danger">
          <template #trigger="{ setIsOpen }">
            <Button
              @click="() => setIsOpen(true)"
              color="gray"
              variant="outline"
              size="sm"
              :leftIcon="TrashIcon"
              v-can="'craftable-pro.order.destroy'"
            >
              {{ $t("craftable-pro", "Delete") }}
            </Button>
          </template>

          <template #title>
            {{ $t("craftable-pro", "Delete Order") }}
          </template>
          <template #content>
            {{
              $t(
                "craftable-pro",
                "Are you sure you want to delete selected Order? All data will be permanently removed from our servers forever. This action cannot be undone."
              )
            }}
          </template>

          <template #buttons="{ setIsOpen }">
            <Button
              @click.prevent="
                () => {
                  bulkAction('post', route('craftable-pro.orders.bulk-destroy'), {
                    onFinish: () => setIsOpen(false),
                  });
                }
              "
              color="danger"
              v-can="'craftable-pro.order.destroy'"
            >
              {{ $t("craftable-pro", "Delete") }}
            </Button>
            <Button
              @click.prevent="() => setIsOpen()"
              color="gray"
              variant="outline"
            >
              {{ $t("craftable-pro", "Cancel") }}
            </Button>
          </template>
        </Modal>
      </template>
      <template #tableHead>
        
        <ListingHeaderCell sortBy="id">
            {{ $t("craftable-pro", "Id") }}
        </ListingHeaderCell> 
        <ListingHeaderCell sortBy="notes">
            {{ $t("craftable-pro", "Notes") }}
        </ListingHeaderCell> 
        <ListingHeaderCell sortBy="created_at">
            {{ $t("craftable-pro", "Created At") }}
        </ListingHeaderCell> 
        <ListingHeaderCell sortBy="updated_at">
            {{ $t("craftable-pro", "Updated At") }}
        </ListingHeaderCell>
        <ListingHeaderCell>
          <span class="sr-only">{{ $t("craftable-pro", "Actions") }}</span>
        </ListingHeaderCell>
      </template>
      <template #tableRow="{ item, action }: any">
        
        <ListingDataCell>
             {{ item.id }}
        </ListingDataCell> 
        <ListingDataCell>
             {{ item.notes }}
        </ListingDataCell> 
        <ListingDataCell>
             {{ dayjs(item.created_at).format('DD.MM.YYYY HH:mm') }}
        </ListingDataCell> 
        <ListingDataCell>
             {{ dayjs(item.updated_at).format('DD.MM.YYYY HH:mm') }}
        </ListingDataCell>
        <ListingDataCell>
          <div class="flex items-center justify-end gap-3">
            <IconButton
              :as="Link"
              :href="route('craftable-pro.orders.edit', item)"
              variant="ghost"
              color="gray"
              :icon="PencilSquareIcon"
              v-can="'craftable-pro.order.edit'"
            />

            <Modal type="danger">
              <template #trigger="{ setIsOpen }">
                <IconButton
                  @click="() => setIsOpen(true)"
                  color="gray"
                  variant="ghost"
                  :icon="TrashIcon"
                  v-can="'craftable-pro.order.destroy'"
                />
              </template>

              <template #title>
                {{ $t("craftable-pro", "Delete Order") }}
              </template>
              <template #content>
                {{
                  $t(
                    "craftable-pro",
                    "Are you sure you want to delete selected Order? All data will be permanently removed from our servers forever. This action cannot be undone."
                  )
                }}
              </template>

              <template #buttons="{ setIsOpen }">
                <Button
                  @click.prevent="
                    () => {
                      action('delete', route('craftable-pro.orders.destroy', item), {
                        onFinish: () => setIsOpen(false),
                      });
                    }
                  "
                  color="danger"
                  v-can="'craftable-pro.order.destroy'"
                >
                  {{ $t("craftable-pro", "Delete") }}
                </Button>
                <Button
                  @click.prevent="() => setIsOpen()"
                  color="gray"
                  variant="outline"
                >
                  {{ $t("craftable-pro", "Cancel") }}
                </Button>
              </template>
            </Modal>
          </div>
        </ListingDataCell>
      </template>
    </Listing>
  </PageContent>
</template>

<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3";
import {
    PlusIcon,
    TrashIcon,
    PencilSquareIcon,
    ArrowDownTrayIcon,
} from "@heroicons/vue/24/outline";
import {
    PageHeader,
    PageContent,
    Button,
    Listing,
    Avatar,
    ListingHeaderCell,
    ListingDataCell,
    Modal,
    Multiselect,
    IconButton,
    FiltersDropdown,
    Publish,
    ListingToggle,
} from "craftable-pro/Components";
import { PaginatedCollection } from "craftable-pro/types/pagination";
import type { Order } from "./types";
import type { PageProps } from "craftable-pro/types/page";
import dayjs from "dayjs";
import customParseFormat from "dayjs/plugin/customParseFormat";

dayjs.extend(customParseFormat)



interface Props {
  orders: PaginatedCollection<Order>;
}
defineProps<Props>();

</script>
