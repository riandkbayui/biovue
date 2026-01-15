<script setup>
import { ref } from 'vue'
import Button from '@/components/Button.vue'
import Input from '@/components/Input.vue'
import Badge from '@/components/Badge.vue'
import Textarea from '@/components/Textarea.vue'
import Radio from '@/components/Radio.vue'
import Checkbox from '@/components/Checkbox.vue'
import Card from '@/components/Card.vue'
import Modal from '@/components/Modal.vue'

defineProps({
  msg: String,
})

const textInput = ref('')
const textareaInput = ref('')
const radioValue = ref('1')
const checkboxValue = ref(false)
const checkboxDanger = ref(true)
const showModal = ref(false)
</script>

<template>
  <div class="p-8 space-y-8">
    <div class="flex justify-between items-center">
      <h1 class="text-3xl font-bold">{{ msg }}</h1>
      <router-link :to="{ name: 'login' }">
        <Button variant="primary">Login</Button>
      </router-link>
    </div>

    <!-- Buttons -->
    <Card>
      <template #header>
        <h2 class="text-xl font-semibold">Buttons</h2>
      </template>
      <div class="space-x-2">
        <Button variant="primary">Primary</Button>
        <Button variant="secondary">Secondary</Button>
        <Button variant="success">Success</Button>
        <Button variant="danger">Danger</Button>
        <Button variant="warning">Warning</Button>
        <Button variant="info">Info</Button>
        <Button variant="light">Light</Button>
        <Button variant="dark">Dark</Button>
      </div>
    </Card>

    <!-- Outline Buttons -->
    <Card>
      <template #header>
        <h2 class="text-xl font-semibold">Outline Buttons</h2>
      </template>
      <div class="space-x-2">
        <Button outline variant="primary">Primary</Button>
        <Button outline variant="secondary">Secondary</Button>
        <Button outline variant="success">Success</Button>
        <Button outline variant="danger">Danger</Button>
        <Button outline variant="warning">Warning</Button>
        <Button outline variant="info">Info</Button>
        <Button outline variant="light">Light</Button>
        <Button outline variant="dark">Dark</Button>
      </div>
    </Card>

    <!-- Badges -->
    <Card>
      <template #header>
        <h2 class="text-xl font-semibold">Badges</h2>
      </template>
      <div class="space-x-2">
        <Badge variant="primary">Primary</Badge>
        <Badge variant="secondary">Secondary</Badge>
        <Badge variant="success">Success</Badge>
        <Badge variant="danger">Danger</Badge>
        <Badge variant="warning">Warning</Badge>
        <Badge variant="info">Info</Badge>
        <Badge variant="light">Light</Badge>
        <Badge variant="dark">Dark</Badge>
      </div>
    </Card>

    <!-- Forms -->
    <Card>
      <template #header>
        <h2 class="text-xl font-semibold">Forms</h2>
      </template>
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Input</label>
          <Input v-model="textInput" placeholder="Enter text" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Textarea</label>
          <Textarea v-model="textareaInput" placeholder="Enter long text" />
        </div>
        <fieldset>
          <legend class="text-base font-medium text-gray-900">Radio Buttons</legend>
          <div class="mt-4 space-x-4">
            <Radio v-model="radioValue" value="1" variant="primary">Primary</Radio>
            <Radio v-model="radioValue" value="2" variant="danger">Danger</Radio>
            <Radio v-model="radioValue" value="3" variant="success">Success</Radio>
          </div>
          <p class="text-sm text-gray-500 mt-1">Selected: {{ radioValue }}</p>
        </fieldset>
        <fieldset>
          <legend class="text-base font-medium text-gray-900">Checkboxes</legend>
          <div class="mt-4 space-x-4">
            <Checkbox v-model="checkboxValue" variant="info">Accept terms</Checkbox>
            <Checkbox v-model="checkboxDanger" variant="danger">Delete all</Checkbox>
          </div>
        </fieldset>
      </div>
    </Card>

    <!-- Modal -->
    <Card>
      <template #header>
        <h2 class="text-xl font-semibold">Modal</h2>
      </template>
      <Button @click="showModal = true">Open Modal</Button>
      <Modal v-model="showModal">
        <template #header>
          Modal Header
        </template>
        <p>This is the modal content. You can put anything here.</p>
        <template #footer>
          <div class="flex justify-end space-x-2">
            <Button variant="light" @click="showModal = false">Close</Button>
            <Button variant="primary" @click="showModal = false">Save Changes</Button>
          </div>
        </template>
      </Modal>
    </Card>

  </div>
</template>