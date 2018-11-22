<?php

/* @var $this yii\web\View */

use \yii\helpers\Url;

?>

<section class="cabinet">
    <div class="container">
        <div class="cabinet__content">
            <div class="main-title">
                <h2><?= Yii::t('main', 'account') ?></h2>
            </div>
            <div class="cabinet__buttons">
                <button class="cabinet__button is-active" data-open="tab-personal-data"><?= Yii::t('main', 'account') ?></button>
                <a class="cabinet__button" href="<?= Url::to(['/account/orders']) ?>"><?= Yii::t('main', 'orders_history') ?></a>
            </div>
            <div class="cabinet__body">
                <div class="cabinet__tabs">
                    <div class="cabinet__tab tab-personal-data is-active">
                        <div class="cabinet__tab-items cabinet__tab-items--personal-data">
                            <div class="cabinet__tab-item">
                                <div class="cabinet__tab-label"><?= Yii::t('main', 'fio') ?></div>
                                <div class="cabinet__tab-field"><?= $user_fio ?></div>
                            </div>
                            <?php if ($user->dob): ?>
                                <div class="cabinet__tab-item">
                                    <div class="cabinet__tab-label"><?= Yii::t('main', 'dob') ?></div>
                                    <div class="cabinet__tab-field"><?= $user->dob ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($user->organization): ?>
                                <div class="cabinet__tab-item">
                                    <div class="cabinet__tab-label"><?= Yii::t('main', 'organization') ?></div>
                                    <div class="cabinet__tab-field"><?= $user->organization ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($user->email): ?>
                                <div class="cabinet__tab-item">
                                    <div class="cabinet__tab-label">E-mail</div>
                                    <div class="cabinet__tab-field"><?= $user->email ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($user->phone): ?>
                                <div class="cabinet__tab-item">
                                    <div class="cabinet__tab-label"><?= Yii::t('main', 'phone') ?></div>
                                    <div class="cabinet__tab-field"><?= $user->phone ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($user->country): ?>
                                <div class="cabinet__tab-item">
                                    <div class="cabinet__tab-label"><?= Yii::t('main', 'country') ?></div>
                                    <div class="cabinet__tab-field"><?= $user->country ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($user->city): ?>
                                <div class="cabinet__tab-item">
                                    <div class="cabinet__tab-label"><?= Yii::t('main', 'city') ?></div>
                                    <div class="cabinet__tab-field"><?= $user->city ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($user->address): ?>
                                <div class="cabinet__tab-item">
                                    <div class="cabinet__tab-label"><?= Yii::t('main', 'address') ?></div>
                                    <div class="cabinet__tab-field"><?= $user->address ?></div>
                                </div>
                            <?php endif; ?>
                            <div class="cabinet__tab-action">
                                <a href="<?= Url::to(['/account/edit']) ?>"><button class="btn-border"><span><?= Yii::t('main', 'edit') ?></span></button></a>
                            </div>
                            <?php if ($user->discount): ?>
                                <div class="cabinet__tab-item">
                                    <div class="cabinet__tab-label"><?= Yii::t('main', 'discount') ?></div>
                                    <div class="cabinet__tab-field"><?= $user->discount ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if ($user->discount_card): ?>
                                <div class="cabinet__tab-item">
                                    <div class="cabinet__tab-label"><?= Yii::t('main', 'discount_card') ?></div>
                                    <div class="cabinet__tab-field"><?= $user->discount_card ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="cabinet__tab tab-history-of-orders">
                        <div class="cabinet__tab-header">
                            <strong><?= Yii::t('main', 'sorting') ?></strong>
                            <div class="dropdown-main dropdown-main--sorting">
                                <div class="dropdown-main__header dropdown-main__header--js-click link-hover">
                                    <p><?= Yii::t('main', 'date_order') ?> ↑↓</p>
                                    <span class="cf-arrow-down"></span>
                                </div>
                                <ul class="dropdown-main__body dropdown-main__body--sorting">
                                    <li class="link-hover link-active">
                                        <a href="#"><?= Yii::t('main', 'revalent_order') ?></a>
                                    </li>
                                    <li class="link-hover">
                                        <a href="#"><?= Yii::t('main', 'filter_price_low') ?></a>
                                    </li>
                                    <li class="link-hover">
                                        <a href="#"><?= Yii::t('main', 'filter_price_height') ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="cabinet__table">
                            <div class="cabinet__table-tr">
                                <div class="cabinet__table-header">
                                    <div class="cabinet__table-item">
                                        <strong><?= Yii::t('main', 'order') ?></strong>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <strong><?= Yii::t('main', 'date') ?></strong>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <strong><?= Yii::t('main', 'sum') ?></strong>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <strong><?= Yii::t('main', 'more') ?></strong>
                                    </div>
                                </div>
                            </div>
                            <div class="cabinet__table-tr">
                                <div class="cabinet__table-header">
                                    <div class="cabinet__table-item">
                                        <strong>№ 878 99</strong>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <span>4.02.2018</span>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <span>452$</span>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <button class="cf-arrow-down"></button>
                                    </div>
                                </div>
                                <div class="cabinet__table-body">
                                    <div class="cabinet__table-items">
                                        <div class="cabinet__table-item">
                                            <p>Кофе</p>
                                            <p>Snipers hide coffee roast</p>
                                        </div>
                                        <div class="cabinet__table-item">
                                            <p>4$\за 50 гр</p>
                                            <p>500 гр</p>
                                        </div>
                                        <div class="cabinet__table-item">
                                            <p>200 грн</p>
                                        </div>
                                        <div class="cabinet__table-item">
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cabinet__table-tr">
                                <div class="cabinet__table-header">
                                    <div class="cabinet__table-item">
                                        <strong>№ 878 99</strong>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <span>4.02.2018</span>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <span>452$</span>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <button class="cf-arrow-down"></button>
                                    </div>
                                </div>
                                <div class="cabinet__table-body">
                                    <div class="cabinet__table-items">
                                        <div class="cabinet__table-item">
                                            <p>Кофе</p>
                                            <p>Snipers hide coffee roast</p>
                                        </div>
                                        <div class="cabinet__table-item">
                                            <p>4$\за 50 гр</p>
                                            <p>500 гр</p>
                                        </div>
                                        <div class="cabinet__table-item">
                                            <p>200 грн</p>
                                        </div>
                                        <div class="cabinet__table-item">
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cabinet__table-tr">
                                <div class="cabinet__table-header">
                                    <div class="cabinet__table-item">
                                        <strong>№ 878 99</strong>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <span>4.02.2018</span>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <span>452$</span>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <button class="cf-arrow-down"></button>
                                    </div>
                                </div>
                                <div class="cabinet__table-body">
                                    <div class="cabinet__table-items">
                                        <div class="cabinet__table-item">
                                            <p>Кофе</p>
                                            <p>Snipers hide coffee roast</p>
                                        </div>
                                        <div class="cabinet__table-item">
                                            <p>4$\за 50 гр</p>
                                            <p>500 гр</p>
                                        </div>
                                        <div class="cabinet__table-item">
                                            <p>200 грн</p>
                                        </div>
                                        <div class="cabinet__table-item">
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cabinet__table-tr">
                                <div class="cabinet__table-header">
                                    <div class="cabinet__table-item">
                                        <strong>№ 878 99</strong>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <span>4.02.2018</span>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <span>452$</span>
                                    </div>
                                    <div class="cabinet__table-item">
                                        <button class="cf-arrow-down"></button>
                                    </div>
                                </div>
                                <div class="cabinet__table-body">
                                    <div class="cabinet__table-items">
                                        <div class="cabinet__table-item">
                                            <p>Кофе</p>
                                            <p>Snipers hide coffee roast</p>
                                        </div>
                                        <div class="cabinet__table-item">
                                            <p>4$\за 50 гр</p>
                                            <p>500 гр</p>
                                        </div>
                                        <div class="cabinet__table-item">
                                            <p>200 грн</p>
                                        </div>
                                        <div class="cabinet__table-item">
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
