<template>
  <PageContent>
    <div class="mx-auto max-w-3xl 2xl:max-w-4xl">
      

      <Card>
        <div class="space-y-4">
            <TextInput
                v-model="form.notes"
                name="notes"
                :label="$t('craftable-pro', 'Notes')"
                
            /></div>
      </Card>
    </div>
  </PageContent>
</template>

<script setup lang="ts">
import {
    Card,
    TextInput,
    Wysiwyg,
    TextArea,
    PageContent,
    DatePicker,
    Checkbox,
    Dropzone,
    ImageUpload,
    Multiselect,
    CardLocaleSwitcher
} from "craftable-pro/Components";
import { InertiaForm } from "craftable-pro/types";
import type { OrderForm } from "./types";



interface Props {
  form: InertiaForm<OrderForm>;
  submit: void;
  
}

const props = defineProps<Props>();
</script>
