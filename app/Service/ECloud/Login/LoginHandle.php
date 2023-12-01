<?php

namespace App\Service\ECloud\Login;

use App\Service\WechatBot\Login\LoginHandleInterface;
use App\Service\WechatBot\Login\QRCodeResponseInterface;
use BaconQrCode\Common\ErrorCorrectionLevel;
use Endroid\QrCode\ErrorCorrectionLevel as EndroidErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;
use BaconQrCode\Renderer\PlainTextRenderer;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;

readonly class LoginHandle implements LoginHandleInterface
{

    public function __construct(
        protected PngWriter $writer,
        protected Filesystem $filesystem,
        protected PlainTextRenderer $plainTextRenderer,
        protected string $qrCodePath = 'qrcode.png'
    ) {
    }

    /**
     * @param QRCodeResponseInterface $response
     * @return string
     */
    public function qRCodeUrlHandle(QRCodeResponseInterface $response): string
    {
        return $this->imageToAscii($response);
    }

    /**
     * 渲染 QrCode
     * @param QRCodeResponseInterface $response
     * @return string
     */
    public function imageToAscii(QRCodeResponseInterface $response): string
    {
        // 创建 QrCode 对象
        $ecLevel = ErrorCorrectionLevel::forBits(1); // 错误更正级别
        $qrCode  = Encoder::encode($response->getQrCodeUrl(), $ecLevel);

        // 使用 PlainTextRenderer 渲染 QrCode
        return $this->plainTextRenderer->render($qrCode);
    }

    /**
     * 保存二维码
     * @param QRCodeResponseInterface $response
     * @param int $size
     * @throws FilesystemException
     */
    public function writeQrCode(QRCodeResponseInterface $response, int $size = 300): void
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($response->getQrCodeUrl())
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(EndroidErrorCorrectionLevel::High)
            ->size($size)
            ->build();

        // 保存二维码文件
        $this->filesystem->write($this->qrCodePath, $result->getString());
    }

}