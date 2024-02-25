<template>
  <header>
    <div class="header__left">
      <img src="/src/assets/logo.svg" alt="logo" class="logo">
      <h3>Umfrage Portal</h3>
    </div>
    <div class="header__right">
      <nav>
        <ul>
          <li>
            <RouterLink to="/">Home</RouterLink>
          </li>
          <li>
            <RouterLink to="/survey/list">Umfragen</RouterLink>
          </li>
        </ul>
      </nav>
      <Avatar imageUrl="https://unchainedcrypto.com/wp-content/uploads/2023/07/pfp-nft.png" class="header__avatar"></Avatar>
    </div>
  </header>
</template>

<style>
  header{
    display: flex;
    justify-content: space-between;
    border-bottom: 2px solid var(--border);
    padding: 5px 40px;
  }

  .header__left{
    display: flex;
    align-items: center;
  }

  .header__left img{
    height: 40px;
    width: auto;
  }

  .header__right ul{
    padding: 0;
    list-style: none;
    display: flex;
  }

  .header__right{
    display: flex;
    align-items: center;
  }

  #app .header__avatar{
    height: 40px;
    width: 40px;
    border: 1px solid black;
  }

  .header__right a{
    color: black;
    text-decoration: none;
    padding: 0 15px;
    transition: all 0.3s;
  }

  .header__right a:hover{
    opacity: .7;
  }
</style>