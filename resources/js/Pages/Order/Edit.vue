<template>
  <PageHeader
    sticky
    :title="$t('craftable-pro', 'Edit Order')"
    :subtitle="`Last updated at ${dayjs(
      order.updated_at
    ).format('DD.MM.YYYY')}`"
  >
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'craftable-pro.order.edit'"
    >
      {{ $t("craftable-pro", "Save") }}
    </Button>
  </PageHeader>

  <Form :form="form" :submit="submit"  />
</template>

<script setup lang="ts">
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, Button } from "craftable-pro/Components";
import { useForm } from "craftable-pro/hooks/useForm";
import Form from "./Form.vue";
import type { Order, OrderForm } from "./types";
import dayjs from "dayjs";
import customParseFormat from "dayjs/plugin/customParseFormat";


dayjs.extend(customParseFormat);



interface Props {
  order: Order;
  
}

const props = defineProps<Props>();

const { form, submit } = useForm<OrderForm>(
    {
          notes: props.order?.notes ?? ""
    },
    route("craftable-pro.orders.update", [props.order?.id])
);
</script>
