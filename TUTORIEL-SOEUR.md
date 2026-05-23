# Guide d'utilisation du site — Un Défi pour Tim
*Pour la gestion du site sans connaissance technique*

---

## 🔐 1. Se connecter

1. Ouvre ton navigateur et va sur :
   **https://undefipourtim.com/wp-admin**

2. Identifiants :
   - **Identifiant** : `admin`
   - **Mot de passe** : *(envoyé séparément)*

3. ⚠️ **Change le mot de passe dès la première connexion** :
   - En haut à droite, clique sur **"Bonjour, admin"**
   - Clique sur **"Modifier le profil"**
   - Fais défiler jusqu'à **"Nouveau mot de passe"**
   - Génère ou tape un nouveau mot de passe
   - Clique sur **"Mettre à jour le profil"**

---

## 🎨 2. Modifier le contenu de la page d'accueil (Elementor)

Le site utilise **Elementor** — un éditeur visuel. Tu cliques sur ce que tu veux changer, tu modifies, tu sauvegardes. Aucune connaissance technique nécessaire.

### 2a. Ouvrir l'éditeur Elementor

1. Dans le menu gauche, clique sur **Pages → Toutes les pages**
2. Passe ta souris sur **"Accueil"**
3. Clique sur **"Modifier avec Elementor"**
4. La page s'ouvre avec le panneau Elementor à gauche et l'aperçu à droite

### 2b. Modifier un texte

1. Clique sur le texte que tu veux modifier dans l'aperçu
2. Le panneau gauche montre les options de ce texte
3. Tape directement dans le champ "Contenu"
4. La modification apparaît en temps réel

### 2c. Modifier une image

1. Clique sur l'image dans l'aperçu
2. Dans le panneau gauche, clique sur l'image actuelle
3. La médiathèque s'ouvre → sélectionne une nouvelle photo ou clique "Téléverser des fichiers"
4. Clique sur **"Insérer"**

### 2d. Ajouter une nouvelle section

1. Clique sur l'icône **"+"** entre deux sections existantes
2. Choisis une mise en page (1 colonne, 2 colonnes, etc.)
3. Clique sur **"Widget"** dans le panneau gauche et fais glisser un élément dans la section :
   - **"Titre"** pour un titre
   - **"Texte"** pour un paragraphe
   - **"Image"** pour une photo
   - **"Shortcode"** pour les sections automatiques (voir section 2f)

### 2e. Supprimer une section ou un élément

1. Survole la section/l'élément → apparaissent des icônes en bleu
2. Clique sur la **corbeille** pour supprimer
3. ⚠️ La suppression est définitive dans Elementor — pense à sauvegarder avant d'expérimenter

### 2f. Sections automatiques (ne pas toucher la mise en page)

Certaines sections sont gérées automatiquement par le site et apparaissent via des **codes courts** (shortcodes). Si tu vois dans l'éditeur un bloc "Shortcode" avec un texte comme `[defitim_defis]`, ne le supprime pas — c'est ce qui affiche automatiquement la liste des défis, le formulaire de contact, etc.

Les shortcodes disponibles :

| Code | Ce qu'il affiche |
|------|-----------------|
| `[defitim_defis]` | La liste des défis (passés et à venir) |
| `[defitim_progress]` | La barre de progression de la collecte |
| `[defitim_help]` | Le module de don + HelloAsso |
| `[defitim_faq]` | La foire aux questions |
| `[defitim_sponsors]` | Les logos des mécènes |
| `[defitim_contact]` | Le formulaire de contact + fiches contacts |

Pour ajouter un de ces blocs quelque part : glisse le widget **"Shortcode"** dans une section, puis colle le code (ex : `[defitim_defis]`).

### 2g. Sauvegarder les modifications

- Clique sur **"METTRE À JOUR"** en bas du panneau gauche
- Le bouton passe au vert → c'est sauvegardé et en ligne immédiatement

### 2h. Quitter l'éditeur sans sauvegarder

- Clique sur la flèche **"←"** en haut à gauche du panneau Elementor
- Choisis **"Abandonner les modifications"** si tu ne veux pas garder les changements

---

## 📸 3. Ajouter des photos (médiathèque)

1. Dans le menu de gauche, clique sur **Médias → Ajouter du média**
2. Glisse-dépose tes photos ou clique sur **"Sélectionner des fichiers"**
3. Les photos sont maintenant disponibles dans toute la médiathèque Elementor

---

## 📊 4. Mettre à jour les chiffres de la collecte

Les chiffres de la barre de progression (montant collecté, nombre de donateurs, etc.) se mettent à jour dans le menu **"Défi Tim"**.

Menu gauche : **Défi Tim → Collecte & FAQ**

| Champ | Ce que c'est |
|-------|-------------|
| Objectif | Montant total à collecter (ex : 42780) |
| Collecté | **À mettre à jour régulièrement** — montant déjà reçu |
| Donateurs | Nombre de donateurs |
| Événements de collecte | Nombre de soirées/events |
| URL HelloAsso | Lien vers le formulaire de don en ligne |
| FAQ | Questions/réponses — clique "Ajouter" pour en ajouter |

👉 Après avoir tout rempli, clique sur **"Mettre à jour"** en haut à droite.

---

## 📬 5. Mettre à jour les contacts et les réseaux sociaux

Menu gauche : **Défi Tim → Contact & Partenaires**

| Champ | Ce que c'est |
|-------|-------------|
| Email de contact | Adresse qui reçoit les messages du formulaire |
| Fiches contact | Nom, téléphone, email des responsables |
| Instagram / Facebook / LinkedIn / BSPP | Les liens vers les réseaux sociaux |
| Partenaires | Un logo + nom + lien pour chaque mécène |

Pour **ajouter un sponsor** :
1. Clique sur **"Ajouter une ligne"** dans la section Partenaires
2. Clique sur **"Ajouter une image"** → sélectionne le logo depuis la médiathèque
3. Remplis le nom et l'URL du site du sponsor

---

## 🏃 6. Gérer les défis (la liste des courses/événements)

Menu gauche : **Les Défis → Ajouter un défi**

Chaque défi est une fiche avec :

| Champ | Ce que c'est |
|-------|-------------|
| Titre | Le nom de l'événement |
| Statut | "À venir", "En cours" ou "Terminé" |
| Date affichée | Ex : "29 mars 2026" |
| Date ISO | Format machine : "2026-03-29" |
| Type | Ex : "Marathon en relais · 42,195 km" |
| Lieu | Ex : "Kourou, Guyane française" |
| Description | Présentation de l'événement |
| Qui | Ex : "20 sapeurs-pompiers de Paris" |
| Objectif collecte | Montant visé en € (chiffre seul, ex : 42780) |
| Collecté | Montant reçu en € |
| Relais | Les segments de course (facultatif) |
| Programme | Le planning du séjour (facultatif) |

**Le premier défi "À venir" ou "En cours" apparaît en grand sur la page d'accueil.**
Les défis "Terminés" apparaissent en bas dans les archives.

---

## 📬 7. Lire les messages reçus (formulaire de contact)

Les messages envoyés via le formulaire arrivent directement dans ta boîte mail.
*(à configurer dans Défi Tim → Contact & Partenaires → Email de contact)*

Il n'y a pas de boîte de réception dans wp-admin à vérifier.

---

## 🌐 8. Changer la langue d'un contenu (Polylang)

Le site est bilingue. Le texte de la page d'accueil que tu modifies dans Elementor est celui visible selon la langue choisie par le visiteur. Pour gérer les deux langues, contacte Victor — il configure la version anglaise séparément.

---

## 💾 9. Enregistrer les modifications (rappel)

- **Dans Elementor** : bouton **"METTRE À JOUR"** en bas du panneau gauche
- **Dans le menu Défi Tim** : bouton **"Mettre à jour"** en haut à droite
- **Pour les défis** : bouton **"Publier"** ou **"Mettre à jour"** en haut à droite
- ✅ Un message vert confirme que c'est sauvegardé

---

## ❓ En cas de problème

- **La page est blanche** : attends 30 secondes et rafraîchis (F5)
- **"Vous n'avez pas les droits"** : contacte Victor
- **Tu as perdu le mot de passe** : contacte Victor — il peut le réinitialiser à distance
- **Elementor ne s'ouvre pas** : essaie dans un autre navigateur (Chrome ou Firefox)
- **Une modification a tout cassé** : dans Elementor, clique sur l'icône horloge 🕐 en bas du panneau gauche → "Historique" → clique sur une version précédente pour restaurer

**Victor** : victor.sdbustamante@gmail.com
