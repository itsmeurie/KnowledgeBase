<script setup>
import { marked } from 'marked';
import { debounce } from 'lodash-es';
import { ref, computed } from 'vue';

const input = ref('#');
const output = computed(() => marked(input.value));

const update = debounce((event) => { 
  input.value = event.target.value;
}, 100);
</script>

<template>
  <div class="editor">
    <textarea class="input" v-model="input"></textarea>
    <div class="output" v-html="output"></div>
  </div>
</template>

<style>
body {
  margin: 0;
  font-family: 'Georgia', serif;
}

.editor {
  height: 100vh;
  display: flex;
}

.input,
.output {
  overflow: auto;
  width: 50%;
  height: 100%;
  box-sizing: border-box;
  padding: 20px;
}

.input {
  border: none;
  border-right: 1px solid #ccc;
  resize: none;
  outline: none;
  background-color: #f6f6f6;
  font-size: 14px;
  font-family: 'Monaco', courier, monospace;
}

.output {
  font-family: 'Arial', sans-serif;
  font-size: 18px;
  line-height: 1.6;
  padding: 20px;
  max-width: 800px;
}

.output h1 {
  font-size: 36px;
  font-weight: bold;
  color: #333;
}

.output h2 {
  font-size: 30px;
  font-weight: bold;
  color: #444;
}

.output h3 {
  font-size: 26px;
  font-weight: bold;
  color: #555;
}

.output p {
  font-size: 18px;
  color: #222;
}

.output ul {
  list-style-type: disc;
  padding-left: 20px;
}

.output ol {
  list-style-type: decimal;
  padding-left: 20px;
}

.output blockquote {
  border-left: 4px solid #ccc;
  padding-left: 10px;
  font-style: italic;
  color: #555;
}

.output table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
}

.output table, th, td {
  border: 1px solid #ddd;
  padding: 8px;
}

.output th {
  background-color: #f4f4f4;
  text-align: left;
}

.output.text-left {
  text-align: left;
}

.output.text-center {
  text-align: center;
}

.output.text-right {
  text-align: right;
}

code {
  color: #f66;
  font-family: 'Courier New', monospace;
  background-color: #f0f0f0;
  padding: 2px 5px;
  border-radius: 4px;
}
</style>
