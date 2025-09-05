<?php

namespace App\MiMascota\Posts\Domain;


interface PostRepository
{
    public function getSoftDeletedPosts(int $page, int $limit): array;
    public function getSoftDeletedPostsByForum(string $forumSlug,int $page, int $limit): array;
    public function getByForumFilterLocation(string $forumSlug, string $locationSlug, int $page, int $limit): array;
    public function getByForumSlug(string $slug, int $page, int $limit): array;
    public function getByUserId(string $userId, int $page, int $limit): array;
    public function getBySlug(string $slug): ?Post;
    public function search(string $id): ?Post;
    public function save(Post $post): void;
    public function remove(Post $post): void;
}
