<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    project: Object
})
</script>

<template>
    <div class="sidebar-container fixed z-20 border">
        <!-- <h1 class="text-xl">Sidebar.vue</h1> -->
        <div>
            <nav class="nav-list-wrapper">
                <ul class="nav-list">
                    <li class="nav-list-item"><Link :href="route('projects.index')">ホーム</Link></li>
                    <li class="nav-list-item"><Link :href="route('projects.tasks.create', {project: project})">課題の追加</Link></li>
                    <li class="nav-list-item"><Link :href="route('projects.tasks.index', {project: project})">課題一覧</Link></li>
                    <li class="nav-list-item"><Link :href="route('projects.board', {project: project})">ボード</Link></li>
                    <li class="nav-list-item"><Link :href="route('projects.gant', {project: project})">ガントチャート</Link></li>
                    <li class="nav-list-item"><Link :href="route('projects.edit', {project: project})">プロジェクト設定</Link></li>
                </ul>
            </nav>
        </div>
    </div>
</template>
<style>
.sidebar-container {
    max-width: 15%;
    min-width: 15%;
    background:  #ffffff;
}
.sidebar-container h1 {
    border-bottom: 1px solid #40b983;
    padding: 20px 0;
    color: #40b983;
}
.nav-list-wrapper {
    padding: 0px;
}
.nav-list-item {
    list-style: none;
    padding: 20px 0;
    padding-left: 40px;
}
.nav-list-item a {
    color: #40b983;
    text-decoration: none;
    display: inline-block;
    width: 100%;
    font-size: 16px;
    font-weight: 700;
}
.nav-list-item a:hover{
    background: #40b983;
    opacity: .8;
    color: #fff;
}
</style>
