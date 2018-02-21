//
//  ScanViewController.m
//  QRtest
//
//  Created by 邵闻远 on 20/04/2017.
//  Copyright © 2017 shaowy. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <AVFoundation/AVFoundation.h>
#import "UIViewController+Message.h"
#import "ScanViewController.h"
#import "SBJson.h"
#import "ViewController.h";

@interface ScanViewController () <AVCaptureMetadataOutputObjectsDelegate>

@property (nonatomic, strong) AVCaptureSession *session;

@property (nonatomic, assign) BOOL flashOpen;

@end

@implementation ScanViewController

@synthesize str1;




- (void)viewDidLoad
{
    [super viewDidLoad];
    
    AVCaptureVideoPreviewLayer *layer = [AVCaptureVideoPreviewLayer layerWithSession:self.session];
    layer.videoGravity = AVLayerVideoGravityResizeAspectFill;
    layer.frame = self.view.layer.bounds;
    [self.view.layer insertSublayer:layer atIndex:0];
}

- (void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    
    [self.session startRunning];
}

- (void)viewWillDisappear:(BOOL)animated
{
    [super viewWillDisappear:animated];
    
    [self.session stopRunning];
}

#pragma mark - AVCaptureMetadataOutputObjectsDelegate
-(void)captureOutput:(AVCaptureOutput *)captureOutput didOutputMetadataObjects:(NSArray *)metadataObjects fromConnection:(AVCaptureConnection *)connection
{
    if (metadataObjects.count > 0)
    {
        [self.session stopRunning];
        
        AVMetadataMachineReadableCodeObject *metadataObject = [metadataObjects firstObject];
        
/*---------------------------------------------------------------*/
        
        @try {
            
            NSString *post = [[NSString alloc] initWithFormat:@"info=%@&gid=%@", metadataObject.stringValue,str1];
            NSLog(@"PostData: %@",post);
            
            NSLog(@"_____________________");
            NSLog(@"str1 = %@", str1);
            NSLog(@"_____________________");
            NSURL *url = [NSURL URLWithString:@"http://172.20.10.5/php/demo/json2.php"];
            
            NSData *postData = [post dataUsingEncoding:NSASCIIStringEncoding allowLossyConversion:YES];
            
            NSString *postLength = [NSString stringWithFormat:@"%d", [postData length]];
            
            NSMutableURLRequest *request = [[NSMutableURLRequest alloc] init];
            [request setURL:url];
            [request setHTTPMethod:@"POST"];
            [request setValue:postLength forHTTPHeaderField:@"Content-Length"];
            [request setValue:@"application/json" forHTTPHeaderField:@"Accept"];
            [request setValue:@"application/x-www-form-urlencoded" forHTTPHeaderField:@"Content-Type"];
            [request setHTTPBody:postData];
            
            NSError *error = [[NSError alloc] init];
            NSHTTPURLResponse *response = nil;
            NSData *urlData = [NSURLConnection sendSynchronousRequest:request returningResponse:&response error:&error];
            
            NSLog(@"Response code: %d", [response statusCode]);
            if ([response statusCode] >= 200 && [response statusCode] < 300) {
                NSString *responseData = [[NSString alloc]initWithData:urlData encoding:NSUTF8StringEncoding];
                NSLog(@"Response ==> %@", responseData);
                
                SBJsonParser *jsonParser = [SBJsonParser new];
                NSDictionary *jsonData = (NSDictionary *)[jsonParser objectWithString:responseData error:nil];
                NSLog(@"%@", jsonData);
                NSInteger success = [(NSNumber *) [jsonData objectForKey:@"success"] integerValue];
                NSLog(@"%d", success);
                if(success == 1) {
                    NSLog(@"Signin success");
                    [self showAlertWithTitle:@"Success!" message:@"check in success!" handler:^(UIAlertAction *action) {
                        [self.session startRunning];
                    }];
                } else if(success == 2){
                    [self showAlertWithTitle:@"Failed!" message:@"Sorry you are late!" handler:^(UIAlertAction *action) {
                        [self.session startRunning];
                    }];
                } else {
                    [self showAlertWithTitle:@"Failed!" message:@"check in failed!" handler:^(UIAlertAction *action) {
                        [self.session startRunning];
                    }];
                }
            } else {
                if (error) {
                    NSLog(@"Error: %@", error);
                    [self showAlertWithTitle:@"Failed!" message:@"coneection failed!" handler:^(UIAlertAction *action) {
                        [self.session startRunning];
                    }];
                }
            }
        } @catch (NSException *e) {
            [self showAlertWithTitle:@"Failed!" message:@"signin failed!" handler:^(UIAlertAction *action) {
                [self.session startRunning];
            }];
        }
        

- (void)rightBarButtonDidClick:(UIBarButtonItem *)item
{
    self.flashOpen = !self.flashOpen;
    
    AVCaptureDevice *device = [AVCaptureDevice defaultDeviceWithMediaType:AVMediaTypeVideo];
    
    if ([device hasTorch] && [device hasFlash])
    {
        [device lockForConfiguration:nil];
        
        if (self.flashOpen)
        {
            self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc] initWithTitle:@"关闭闪光灯" style:UIBarButtonItemStylePlain target:self action:@selector(rightBarButtonDidClick:)];
            
            device.torchMode = AVCaptureTorchModeOn;
            device.flashMode = AVCaptureFlashModeOn;
        }
        else
        {
            self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc] initWithTitle:@"打开闪光灯" style:UIBarButtonItemStylePlain target:self action:@selector(rightBarButtonDidClick:)];
            
            device.torchMode = AVCaptureTorchModeOff;
            device.flashMode = AVCaptureFlashModeOff;
        }
        
        [device unlockForConfiguration];
    }
}



#pragma mark - Getter
- (AVCaptureSession *)session
{
    if (!_session)
    {
        _session = ({
          
            AVCaptureDevice *device = [AVCaptureDevice defaultDeviceWithMediaType:AVMediaTypeVideo];
            
            AVCaptureDeviceInput *input = [AVCaptureDeviceInput deviceInputWithDevice:device error:nil];
            if (!input)
            {
                return nil;
            }
            
            
            AVCaptureMetadataOutput *output = [[AVCaptureMetadataOutput alloc] init];
            
            [output setMetadataObjectsDelegate:self queue:dispatch_get_main_queue()];
            
            CGFloat width = 300 / CGRectGetHeight(self.view.frame);
            CGFloat height = 300 / CGRectGetWidth(self.view.frame);
            output.rectOfInterest = CGRectMake((1 - width) / 2, (1- height) / 2, width, height);
            
            AVCaptureSession *session = [[AVCaptureSession alloc] init];
           
            [session setSessionPreset:AVCaptureSessionPresetHigh];
            [session addInput:input];
            [session addOutput:output];
            
            
            output.metadataObjectTypes = @[AVMetadataObjectTypeQRCode,
                                           AVMetadataObjectTypeEAN13Code,
                                           AVMetadataObjectTypeEAN8Code,
                                           AVMetadataObjectTypeCode128Code];
            
            session;
        });
    }
    
    return _session;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
